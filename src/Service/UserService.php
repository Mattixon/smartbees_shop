<?php

/**
 * @file Contains Drupal\smartbees_shop\Service\UserService.
 */
namespace Drupal\smartbees_shop\Service;

/**
 * Defines the User entity.
 */
class UserService {

  /**
   * User username.
   * @var string
   */
  private string $username;

  /**
   * User password.
   * @var string
   */
  private string $password;

  /**
   * User's name.
   * @var string
   */
  private string $name;

  /**
   * User surname.
   * @var string
   */
  private string $surname;

  /**
   * User living country.
   * @var string
   */
  private string $country;

  /**
   * User living address.
   * @var string
   */
  private string $address;

  /**
   * User living zip code.
   * @var string
   */
  private string $zip;

  /**
   * User living city.
   * @var string
   */
  private string $city;

  /**
   * User phone number.
   * @var int
   */
  private int $phone;

  /**
   * User entry array for database.
   * @var array
   */
  private array $entry;

  /**
   * Constructor for UserService class.
   */
  public function __construct(string $username, string $password, string $name, string $surname, string $country, string $address, string $zip, string $city, int $phone) {
    $this->username = $username;
    $this->password = $password;
    $this->name = $name;
    $this->surname = $surname;
    $this->country = $country;
    $this->address = $address;
    $this->zip = $zip;
    $this->city = $city;
    $this->phone = $phone;
    $this->createEntryField();
  }

  /**
   * Private function for creating entry property.
   */
  private function createEntryField() {
    $this->entry = [
      'username' => $this->username,
      'password' => $this->password,
      'name' => $this->name,
      'surname' => $this->surname,
      'country' => $this->country,
      'address' => $this->address,
      'zip' => $this->zip,
      'city' => $this->city,
      'phone' => $this->phone,
    ];
  }

  /**
   * Function for adding new User.
   *
   * @return bool .
   */
  public function addUser(): bool {
    $database = \Drupal::database();
    try {
      $database
        ->insert('smartbees_shop_user')
        ->fields($this->entry)
        ->execute();
      return true;

    } catch (\Exception $e) {
      return false;
    }
  }
}

