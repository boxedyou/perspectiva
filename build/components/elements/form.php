<form class="form">
  <h2 class="form__title">Есть вопросы? Задавайте, мы перезвоним!</h2>
  <p class="form__subtitle">Наши специалисты оперативно проконсультируют вас и подготовят предварительный расчёт стоимости продукции и работ.</p>
  <fieldset class="form__wrapper">
    <div class="form__inner">
      <label class="form__label">
        <span class="form__label-text">Ваше имя <span class="form__label-required">*</span></span>
        <input class="form__input" type="text" name="Имя" placeholder="Введите имя" required>
      </label>
      <label class="form__label">
        <span class="form__label-text">Контактный телефон <span class="form__label-required">*</span></span>
        <input class="form__input" type="tel" name="Телефон" placeholder="Номер телефона" required>
      </label>
      <label class="form__label">
        <span class="form__label-text">Организация (необязательно)</span>
        <input class="form__input" type="text" name="Организация" placeholder="Название организации">
      </label>
    </div>
    <div class="form__button-inner">
      <button class="form__button" type="submit">Отправить</button>
      <label class="form__checkbox-inner">
        <input class="form__checkbox" type="checkbox" name="Согласие" required>
        <span class="form__fake-checkbox"></span>
        <span class="form__text-checkbox">Нажимая кнопку «Отправить», я соглашаюсь с <a class="form__text-link" href="#" target="_blank">политикой конфиденциальности и обработки персональных данных</a></span>
      </label>
    </div>
  </fieldset>
</form>