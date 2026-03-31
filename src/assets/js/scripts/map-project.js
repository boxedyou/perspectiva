if (typeof window.mapLoaded === 'undefined') {
    window.mapLoaded = false;
}

const loaderYandexProject = document.querySelector('.map-project__loader');

const siteUrl = (window.ajaxurl_object && window.ajaxurl_object.site_url) || '/';
const assetsUrl = (window.ajaxurl_object && window.ajaxurl_object.assets_url) || '';

const projectsData =
    (window.ajaxurl_object && Array.isArray(window.ajaxurl_object.projects_data))
        ? window.ajaxurl_object.projects_data
        : [];

function spreadDuplicateCoords(points) {
    const seen = new Map();

    return points
        .filter(p => p && Array.isArray(p.coords) && p.coords.length === 2)
        .map((p) => {
            const lat = Number(p.coords[0]);
            const lng = Number(p.coords[1]);

            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return null;

            const key = `${lat.toFixed(6)},${lng.toFixed(6)}`;
            const idx = seen.get(key) || 0;
            seen.set(key, idx + 1);

            if (idx === 0) {
                return { ...p, coords: [lat, lng] };
            }

            // Небольшое смещение для дубликатов (~10-20 м)
            const step = 0.00015 * idx;
            return { ...p, coords: [lat + step, lng + step] };
        })
        .filter(Boolean);
}

function loadYandexMap() {
    if (window.mapLoaded) return;

    if (typeof ymaps !== 'undefined') {
        window.mapLoaded = true;
        initMap();
        return;
    }

    window.mapLoaded = true;

    const script = document.createElement('script');
    script.src = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=46bd9dbf-9967-413d-b14e-fc1e1b2980f7';
    script.onload = initMap;
    document.body.appendChild(script);
}

function initMap() {
    ymaps.ready(function () {
        const map = new ymaps.Map('map-project', {
            center: [58.925528, 81.592772],
            zoom: 3.5,
            controls: ['zoomControl']
        });

        map.behaviors.disable([
            'scrollZoom',
            'multiTouch',
            'dblClickZoom',
            'rightMouseButtonMagnifier'
        ]);

        createMapMarkers(projectsData, map);
    });
}

function createMapMarkers(points, map) {
    const normalizedPoints = spreadDuplicateCoords(points);

    const CustomBalloonLayout = ymaps.templateLayoutFactory.createClass(
        `<div class="custom-balloon">
            <div class="custom-balloon__close" title="Закрыть">
                <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3 13.3c.39-.39 1.03-.39 1.41 0L20 18.6l5.29-5.29c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41L21.4 20l5.3 5.29c.39.39.39 1.02 0 1.41-.39.39-1.02.39-1.41 0L20 21.4l-5.29 5.3c-.39.39-1.02.39-1.41 0-.39-.39-.39-1.02 0-1.41L18.6 20l-5.3-5.29c-.39-.39-.39-1.02 0-1.41z" fill="#BACCE0"/>
                </svg>
            </div>
            <h3 class="custom-balloon__city">{{properties.city}}</h3>
            <div class="custom-balloon__wrapper">
                {% if properties.img %}
                <img class="custom-balloon__img" src="{{properties.img}}" alt="{{properties.title}}" width="472" height="282" loading="lazy">
                {% endif %}
                <div class="custom-balloon__inner">
                    <div class="custom-balloon__company">{{properties.company_name}}</div>
                    <div class="custom-balloon__description">{{properties.description}}</div>
                    <div class="custom-balloon__city-bottom">{{properties.city}}</div>
                </div>
            </div>
        </div>`,
        {
            build: function () {
                CustomBalloonLayout.superclass.build.call(this);
                this._$element = document.querySelector('.custom-balloon');
                if (this._$element) {
                    this._$element
                        .querySelector('.custom-balloon__close')
                        .addEventListener('click', () => this.events.fire('userclose'));
                }
            }
        }
    );

    const clusterer = new ymaps.Clusterer({
        groupByCoordinates: false,
        clusterDisableClickZoom: false,
        clusterHideIconOnBalloonOpen: false,
        geoObjectHideIconOnBalloonOpen: false,
        gridSize: 64, // вместо 100000
        clusterOpenBalloonOnClick: true,
        clusterIcons: [{
            href: '',
            size: [52, 52],
            offset: [-26, -26]
        }],
        clusterIconContentLayout: ymaps.templateLayoutFactory.createClass(
            `<div style="
                width:52px;
                height:52px;
                border-radius:50%;
                background:#fff;
                border:6px solid rgba(196, 37, 57, 1);
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:14px;
                color:rgba(31, 31, 31, 1);
            ">$[properties.geoObjects.length]</div>`
        )
    });

    const pinUrl = assetsUrl + '/images/map-projects/pin.svg';

    const placemarks = normalizedPoints.map(point => {
        return new ymaps.Placemark(point.coords, {
            city: point.city || point.title,
            title: point.title || '',
            company_name: point.company_name || '',
            description: point.description || '',
            link: point.link || '',
            hintContent: point.city || point.title || '',
            img: point.img || ''
        }, {
            balloonLayout: CustomBalloonLayout,
            balloonPanelMaxMapArea: 0,
            iconLayout: 'default#image',
            iconImageHref: pinUrl,
            iconImageSize: [40, 40],
            iconImageOffset: [-20, -40]
        });
    });

    clusterer.add(placemarks);
    map.geoObjects.add(clusterer);

    placemarks.forEach(placemark => {
        placemark.events.add('balloonopen', function () {
            const balloonElement = document.querySelector('.custom-balloon');
            if (!balloonElement) return;

            const screenWidth = window.innerWidth;

            if (screenWidth <= 991) {
                const balloonWidth = balloonElement.offsetWidth;
                placemark.options.set('balloonOffset', [-balloonWidth / 2, 0]);
            } else {
                const balloonWidth = balloonElement.offsetWidth;
                placemark.options.set('balloonOffset', [balloonWidth / 4, 0]);
            }

            const coords = placemark.geometry.getCoordinates();
            const projection = map.options.get('projection');
            const globalPixel = projection.toGlobalPixels(coords, map.getZoom());

            const balloonHeight = balloonElement.offsetHeight;
            const newGlobalPixel = [globalPixel[0], globalPixel[1] + balloonHeight / 2];
            const newCoords = projection.fromGlobalPixels(newGlobalPixel, map.getZoom());

            map.setCenter(newCoords, map.getZoom(), { duration: 300 });
        });
    });

    if (loaderYandexProject) {
        loaderYandexProject.classList.add('hidden');
    }
}

const targetYandexProject = document.querySelector('[data-map-project]');
if (targetYandexProject) {
    const mapProjectObserver = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            loadYandexMap();
            mapProjectObserver.disconnect();
        }
    });
    mapProjectObserver.observe(targetYandexProject);
}

const mapElement = document.getElementById('map-project');
if (mapElement && !targetYandexProject) {
    loadYandexMap();
}