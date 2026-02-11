if (typeof window.mapLoaded === 'undefined') {
    window.mapLoaded = false;
}

const loaderYandexProject = document.querySelector(".map-project__loader");

// Тестовые данные проектов
const projectsData = [
    {
        coords: [55.7558, 37.6173], // Москва
        city: 'Москва',
        title: 'Проект 1',
        company_name: 'Компания 1',
        description: 'Описание проекта 1',
        link: '/project/1',
        img: '/perspectiva/build/assets/images/object/1.jpg'
    },
    {
        coords: [59.9343, 30.3351], // Санкт-Петербург
        city: 'Санкт-Петербург',
        title: 'Проект 2',
        company_name: 'Компания 2',
        description: 'Описание проекта 2',
        link: '/project/2',
        img: '/perspectiva/build/assets/images/object/2.jpg'
    },
    {
        coords: [56.8431, 60.6454], // Екатеринбург
        city: 'Екатеринбург',
        title: 'Проект 3',
        company_name: 'Компания 3',
        description: 'Описание проекта 3',
        link: '/project/3',
        img: '/perspectiva/build/assets/images/object/3.jpg'
    },
    {
        coords: [55.0084, 82.9357], // Новосибирск
        city: 'Новосибирск',
        title: 'Проект 4',
        company_name: 'Компания 4',
        description: 'Описание проекта 4',
        link: '/project/4',
        img: '/perspectiva/build/assets/images/object/4.jpg'
    },
    {
        coords: [55.0080, 82.9350], // Новосибирск
        city: 'Новосибирск',
        title: 'Проект 4',
        company_name: 'Компания 4',
        description: 'Описание проекта 4',
        link: '/project/4',
        img: '/perspectiva/build/assets/images/object/4.jpg'
    },
    {
        coords: [53.2001, 50.15], // Самара
        city: 'Самара',
        title: 'Проект 5',
        company_name: 'Компания 5',
        description: 'Описание проекта 5',
        link: '/project/5',
        img: '/perspectiva/build/assets/images/object/5.jpg'
    },
    {
        coords: [56.3269, 44.0075], // Нижний Новгород
        city: 'Нижний Новгород',
        title: 'Проект 6',
        company_name: 'Компания 6',
        description: 'Описание проекта 6',
        link: '/project/6',
        img: '/perspectiva/build/assets/images/object/6.jpg'
    }
];

function loadYandexMap() {
    if (window.mapLoaded) return;

    if (typeof ymaps !== 'undefined') {
        window.mapLoaded = true;
        initMap();
        return;
    }

    window.mapLoaded = true;

    const script = document.createElement("script");
    script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=46bd9dbf-9967-413d-b14e-fc1e1b2980f7";
    script.onload = initMap;
    document.body.appendChild(script);
}

function initMap() {
    ymaps.ready(function () {
        const map = new ymaps.Map("map-project", {
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

        // Используем данные из массива
        createMapMarkers(projectsData, map);
    });
}

function createMapMarkers(points, map) {
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
                <img class="custom-balloon__img" src="{{properties.img}}" alt="Ангары" width="472" height="282" loading="lazy">
                {% endif %}
                <div class="custom-balloon__inner">
                    <div class="custom-balloon__company">{{properties.company_name}}</div>
                    <div class="custom-balloon__description">{{properties.description}}</div>
                    <div class="custom-balloon__city-bottom">{{properties.city}}</div>
                    <div class="custom-balloon__link"><a href="{{properties.link}}" target="_blank">Узнать подробнее</a></div>
                </div>
            </div>
        </div>`,
        {
            build: function () {
                CustomBalloonLayout.superclass.build.call(this);
                this._$element = document.querySelector('.custom-balloon');
                if (this._$element) {
                    this._$element.querySelector('.custom-balloon__close')
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
        gridSize: 100000,
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
                border: 6px solid rgba(196, 37, 57, 1);
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:14px;
                color: rgba(31, 31, 31, 1);
            ">$[properties.geoObjects.length]</div>`
        )
    });

    // Определяем базовый путь автоматически
    const basePath = window.location.pathname.split('/build/')[0] + '/build';
    const pinUrl = basePath + '/assets/images/map-projects/pin.svg';

    const placemarks = points.map(point => {
        const screenWidth = window.innerWidth;

        // Определяем смещение баллуна в зависимости от ширины экрана
        let balloonOffsetX = 0;
        let balloonOffsetY = 0;

        if (screenWidth <= 991) {
            // Для мобильных - центрируем баллун (смещение влево на половину ширины)
            // Ширина баллуна примерно 472px, поэтому смещаем на -236px
            balloonOffsetX = -236;
            balloonOffsetY = 0;
        } else {
            // Для больших экранов - смещение вправо
            balloonOffsetX = 118; // balloonWidth / 4
            balloonOffsetY = 0;
        }

        return new ymaps.Placemark(point.coords, {
            city: point.city || point.title,
            title: point.title,
            company_name: point.company_name,
            description: point.description,
            link: point.link,
            hintContent: point.city || point.title,
            img: point.img
        }, {
            balloonLayout: CustomBalloonLayout,
            balloonPanelMaxMapArea: 0,
            balloonOffset: [balloonOffsetX, balloonOffsetY],
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

            // Динамически обновляем смещение при открытии баллуна
            if (screenWidth <= 991) {
                const balloonWidth = balloonElement.offsetWidth;
                // Центрируем: смещаем влево на половину ширины
                placemark.options.set('balloonOffset', [-balloonWidth / 2, 0]);
            } else {
                const balloonWidth = balloonElement.offsetWidth;
                placemark.options.set('balloonOffset', [balloonWidth / 4, 0]);
            }

            const coords = placemark.geometry.getCoordinates();
            const projection = map.options.get('projection');
            const globalPixel = projection.toGlobalPixels(coords, map.getZoom());

            const balloonHeight = balloonElement.offsetHeight;
            let offsetY = balloonHeight / 2;

            const newGlobalPixel = [
                globalPixel[0],
                globalPixel[1] + offsetY
            ];

            const newCoords = projection.fromGlobalPixels(newGlobalPixel, map.getZoom());
            map.setCenter(newCoords, map.getZoom(), {duration: 300});
        });
    });

    if (loaderYandexProject) loaderYandexProject.classList.add("hidden");
}

// Инициализация карты при появлении в viewport
const targetYandexProject = document.querySelector("[data-map-project]");
if (targetYandexProject) {
    const mapProjectObserver = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            loadYandexMap();
            mapProjectObserver.disconnect();
        }
    });
    mapProjectObserver.observe(targetYandexProject);
}

// Альтернатива для тестовой страницы
const mapElement = document.getElementById("map-project");
if (mapElement && !targetYandexProject) {
    loadYandexMap();
}

