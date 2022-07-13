<?php

/**
 * @file Contains Drupal\smartbees_shop\Form\OrderCheckout.
 */

namespace Drupal\smartbees_shop\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\smartbees_shop\Service\OrderService;
use Drupal\smartbees_shop\Service\UserService;

/**
 * @class OrderCheckout.
 */
class OrderCheckoutForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'order_checkout';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $base_path = Url::fromRoute('<front>')->toString();

    /**
     * Adding library to form.
     */
    $form['#attached']['library'][] = 'smartbees_shop/CheckoutForm';

    /**
     * Main form wrapper for AJAX purpose.
     */
    $form['#prefix'] = '<div id="form-checkout">';
    $form['#suffix'] = '</div>';

    /**
     * Column user data.
     */
    $form['user_data'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'user-data',
      ],
    ];
    $form['user_data']['header'] = [
      '#type' => 'markup',
      '#markup' => '<h2>1. ' . $this->t('Your data') . '</h2>',
    ];
    $form['user_data']['log_in_button'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Login'),
    ];
    $form['user_data']['log_in_popup'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'login-popup',
      ],
      '#states' => [
        'visible' => [
          ':input[name="log_in_button"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['log_in_popup']['x_button'] = [
      '#type' => 'button',
      '#value' => 'x',
    ];
    $form['user_data']['log_in_popup']['username'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Username'),
    ];
    $form['user_data']['log_in_popup']['password'] = [
      '#type' => 'password',
      '#placeholder' => $this->t('Password'),
    ];
    $form['user_data']['log_in_popup']['submit'] = [
      '#type' => 'button',
      '#value' => $this->t('Login'),
    ];
    $form['user_data']['log_in_desc'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('Already have an account? Click to log in.') . '</p>',
    ];
    $form['user_data']['create_account'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Create a new account.'),
    ];
    $form['user_data']['create_account_container'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'create-account-container',
      ],
      '#states' => [
        'visible' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['username'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Username'),
    ];
    $form['user_data']['create_account_container']['password'] = [
      '#type' => 'password',
      '#placeholder' => $this->t('Password'),
    ];
    $form['user_data']['create_account_container']['repeat_password'] = [
      '#type' => 'password',
      '#placeholder' => $this->t('Repeat password'),
    ];
    $form['user_data']['create_account_container']['name'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Name') . ' *',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['surname'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Surname') . ' *',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['country'] = [
      '#type' => 'select',
      '#options' => [
        '0' => $this->t('Poland'),
        '1' => $this->t('Germany'),
        '2' => $this->t('United Kingdom'),
        '3' => $this->t('United States'),
      ],
      '#default_value' => '0',
    ];
    $form['user_data']['create_account_container']['address'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Address') . ' *',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['living_place'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'living-place',
      ],
    ];
    $form['user_data']['create_account_container']['living_place']['zip_code'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('ZIP code') . ' *',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['living_place']['city'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('City') . ' *',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['user_data']['create_account_container']['tel'] = [
      '#type' => 'tel',
      '#placeholder' => $this->t('Phone') . ' *',
      '#pattern' => '[0-9]{5,15}',
      '#states' => [
        'required' => [
          ':input[name="create_account"]' => ['checked' => TRUE],
        ],
      ],
    ];

    /**
     * Column delivery and payment.
     */
    $form['delivery_and_payment'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'delivery-and-payment',
      ],
    ];
    $form['delivery_and_payment']['delivery'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'delivery',
      ],
    ];
    $form['delivery_and_payment']['delivery']['header'] = [
      '#type' => 'markup',
      '#markup' => '<h2>2. ' . $this->t('Delivery methods') . '</h2>',
    ];
    $form['delivery_and_payment']['delivery']['delivery'] = [
      '#type' => 'radios',
      '#options' => [
        'parcel' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/inpost.jpg">' . $this->t('Parcel lockers 24/7') . ' <span class="price">10,99 zł</span>',
        'dpd' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/dpd.jpg">' . $this->t('DPD courier') . ' <span class="price">18,00 zł</span>',
        'dpd-cash' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/dpd.jpg">' . $this->t('DPD courier on delivery') . ' <span class="price">22,00 zł</span>',
      ],
      '#attributes' => [
        'name' => 'delivery',
      ],
    ];
    $form['delivery_and_payment']['payment'] = [
      '#type' => 'container',
    ];
    $form['delivery_and_payment']['payment']['header'] = [
      '#type' => 'markup',
      '#markup' => '<h2>3. ' . $this->t('Payment methods') . '</h2>',
    ];
    $form['delivery_and_payment']['payment']['payment_container_1'] = [
      '#type' => 'container',
      '#states' => [
        'visible' => [
          ':input[name="delivery"]' => [
            ['value' => 'parcel'],
            'or',
            ['value' => 'dpd'],
          ],
        ],
      ],
    ];
    $form['delivery_and_payment']['payment']['payment_container_1']['payment_1'] = [
      '#type' => 'radios',
      '#options' => [
        'payu' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/payu.jpg">' . $this->t('PayU'),
        'bank transfer' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/przekaz.jpg">' . $this->t('Ordinary bank transfer'),
      ],
    ];
    $form['delivery_and_payment']['payment']['payment_container_2'] = [
      '#type' => 'container',
      '#states' => [
        'visible' => [
          ':input[name="delivery"]' => ['value' => 'dpd-cash'],
        ],
      ],
    ];
    $form['delivery_and_payment']['payment']['payment_container_2']['payment_2'] = [
      '#type' => 'radios',
      '#options' => [
        'cash on delivery' => '<img src="' . $base_path . 'modules/custom/smartbees_shop/images/pobranie.jpg">' . $this->t('Cash on delivery'),
      ],
    ];

    /**
     * Column summary.
     */
    $form['summary'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'summary',
      ],
    ];
    $form['summary']['header'] = [
      '#type' => 'markup',
      '#markup' => '<h2>4. ' . $this->t('Summary') . '</h2>',
    ];
    $form['summary']['product'] = [
      '#type' => 'markup',
      '#markup' =>
        '<div class="product">
            <div class="image"></div>
            <div class="description">
                <p class="name">' . $this->t('Test product') . '</p>
                <p class="amount">' . $this->t('Amount') . ' :1</p>
            </div>
            <div class="price">115,00 zł</div>
        </div>',
    ];
    $form['summary']['sum'] = [
      '#type' => 'markup',
      '#markup' =>
        '<div class="sum">
            <p class="sum-partial">
                <span>' . $this->t('Partial sum') . '</span>
                <span>115,00 zł</span>
            </p>
            <p class="sum-final">
                <span>' . $this->t('Together') . '</span>
                <span>115,00 zł</span>
            </p>
        </div>',
    ];
    $form['summary']['comment'] = [
      '#type' => 'textarea',
      '#placeholder' => $this->t('Comment'),
    ];
    $form['summary']['newsletter'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Subscribe to receive the newsletter.'),
    ];
    $form['summary']['terms'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('I have read the <span>terms</span> of purchase.'),
    ];
    $form['summary']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Confirm purchase'),
      '#ajax' => [
        'wrapper' => 'form-checkout',
      ]
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $messenger = \Drupal::messenger();
    $create_account = $form_state->getValue('create_account');

    /**
     * New user fields.
     */
    !empty($form_state->getValue('username')) ? $username = $form_state->getValue('username') : $username = '';
    !empty($form_state->getValue('password')) ? $password = $form_state->getValue('username') : $password = '';
    $name = $form_state->getValue('name');
    $surname = $form_state->getValue('surname');
    $countryID = $form_state->getValue('country');
    $country = $form['user_data']['create_account_container']['country']['#options'][$countryID]->getUntranslatedString();
    $address = $form_state->getValue('address');
    $zip_code = $form_state->getValue('zip_code');
    $city = $form_state->getValue('city');
    $phone = $form_state->getValue('tel');

    /**
     * Order fields.
     */
    /* User id is random generate, and it's for show only, how the tables are combined through foreign key. */
    $user_id = rand(0,100);
    !empty($form_state->getValue('delivery')) ? $delivery = $form_state->getValue('delivery') : $delivery = '';
    !empty($form_state->getValue('payment_1')) ? $payment_1 = $form_state->getValue('payment_1') : $payment_1 = '';
    !empty($form_state->getValue('payment_2')) ? $payment_2 = $form_state->getValue('payment_2') : $payment_2 = '';
    !empty($form_state->getValue('comment')) ? $comment = $form_state->getValue('comment') : $comment = '';
    /* Below fields are not included in form. They will always return empty string or false. This is only for show. */
    !empty($form_state->getValue('different_address')) ? $different_address = $form_state->getValue('different_address') : $different_address = 0;
    !empty($form_state->getValue('delivery_country')) ? $delivery_country = $form_state->getValue('delivery_country') : $delivery_country = '';
    !empty($form_state->getValue('delivery_address')) ? $delivery_address = $form_state->getValue('delivery_address') : $delivery_address = '';
    !empty($form_state->getValue('delivery_zip_code')) ? $delivery_zip_code = $form_state->getValue('delivery_zip_code') : $delivery_zip_code = '';
    !empty($form_state->getValue('delivery_city')) ? $delivery_city = $form_state->getValue('delivery_city') : $delivery_city = '';

    $payment = '';

    if($delivery === 'parcel' || $delivery === 'dpd') {
      $payment = $payment_1;
    } else {
      $payment = $payment_2;
    }

    if($create_account) {
      $userService = new UserService($username, $password, $name, $surname, $country, $address, $zip_code, $city, $phone);
      $userService->addUser();
    }

    $orderService = new OrderService($user_id, $delivery, $payment, $comment, $different_address, $delivery_country, $delivery_address, $delivery_zip_code, $delivery_city);
    $orderMessage = $orderService->addOrder();

    /* For show only, order number is the same as user id */
    $orderNumber = $user_id;

    ($orderMessage)
      ? $messenger->addMessage($this->t('Everything is correct, your order number is: ') . $orderNumber)
      : $messenger->addError($this->t('Ehh, and you had to break it..'));
  }
}
