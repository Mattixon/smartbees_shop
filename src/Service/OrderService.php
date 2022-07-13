<?php

/**
 * @file Contains Drupal\smartbees_shop\Service\OrderService.
 */
namespace Drupal\smartbees_shop\Service;

/**
 * Defines the Order entity.
 */
class OrderService {

  /**
   * Order user's id.
   * @var int
   */
  private int $user_id;

  /**
   * Order delivery method.
   * @var string
   */
  private string $delivery;

  /**
   * Order payment method.
   * @var string
   */
  private string $payment;

  /**
   * Order comment.
   * @var string
   */
  private string $comment;

  /**
   * Order is different address?
   * @var int
   */
  private int $different_address;

  /**
   * Order delivery country.
   * @var string
   */
  private string $country;

  /**
   * Order delivery address.
   * @var string
   */
  private string $address;

  /**
   * Order delivery zip code.
   * @var string
   */
  private string $zip;

  /**
   * Order delivery city.
   * @var int
   */
  private string $city;

  /**
   * User entry array for database.
   * @var array
   */
  private array $entry;

  /**
   * Constructor for OrderService class.
   */
  public function __construct(int $user_id, string $delivery, string $payment, string $comment, int $different_address, string $country, string $address, string $zip, string $city) {
    $this->user_id = $user_id;
    $this->delivery = $delivery;
    $this->payment = $payment;
    $this->comment = $comment;
    $this->different_address = $different_address;
    $this->country = $country;
    $this->address = $address;
    $this->zip = $zip;
    $this->city = $city;
    $this->createEntryField();
  }

  /**
   * Private function for creating entry property.
   */
  private function createEntryField() {
    $this->entry = [
      'user_id' => $this->user_id,
      'delivery' => $this->delivery,
      'payment' => $this->payment,
      'comment' => $this->comment,
      'different_address' => $this->different_address,
      'country' => $this->country,
      'address' => $this->address,
      'zip' => $this->zip,
      'city' => $this->city,
    ];
  }

  /**
   * Function for adding new User.
   *
   * @return bool .
   */
  public function addOrder(): bool {
    $database = \Drupal::database();
    try {
      $database
        ->insert('smartbees_shop_order')
        ->fields($this->entry)
        ->execute();
      return true;

    } catch (\Exception $e) {
      return false;
    }
  }
}

