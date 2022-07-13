(function ($) {

  class OrderCheckoutForm {
    #$domElement;
    #createAccountCheckbox;

    constructor($domElement) {
      this.#$domElement = $domElement;
      this.#createAccountCheckbox = $domElement.find('div.form-item-create-account > input.form-checkbox');
      this.#turnoffNewAccountForm();
      this.#turnoffPopup();
    }

    #turnoffNewAccountForm() {
      this.#$domElement.find('input#edit-log-in-button').mousedown(() => {
        if(this.#createAccountCheckbox.is(':checked')) {
          this.#createAccountCheckbox.trigger('click');
        }
      });
    }

    #turnoffPopup() {
      this.#$domElement.find('div#login-popup > input.button').click(function(event) {
        event.preventDefault();
        $('div.form-item-log-in-button > input.form-checkbox').trigger('click');
      });
    }
  }

  Drupal.behaviors.order_checkout_form = {
    attach: context => {
      $('form.order-checkout').each(function() {
        new OrderCheckoutForm($(this));
      });
    }
  }

})(jQuery)
