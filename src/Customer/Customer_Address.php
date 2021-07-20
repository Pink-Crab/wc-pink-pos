<?php

declare(strict_types=1);

/**
 * Customer address model
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer Customer
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Customer;

class Customer_Address {

	/**
	 * Address line 1
	 *
	 * @var string
	 */
	protected $address_1 = '';

	/**
	 * Address line 2
	 *
	 * @var string
	 */
	protected $address_2 = '';

	/**
	 * City or Town
	 *
	 * @var string
	 */
	protected $city = '';

	/**
	 * County or State
	 *
	 * @var string
	 */
	protected $county = '';

	/**
	 * Postcode or Zip
	 *
	 * @var string
	 */
	protected $postcode = '';

	/**
	 * Country
	 *
	 * @var string
	 */
	protected $country = '';

	/**
	 * Create address.
	 *
	 * @param string $address_1
	 * @param string $address_2
	 * @param string $city
	 * @param string $county
	 * @param string $postcode
	 * @param string $country
	 */
	public function __construct(
		string $address_1,
		string $address_2,
		string $city,
		string $county,
		string $postcode,
		string $country
	) {
		$this->address_1 = $address_1;
		$this->address_2 = $address_2;
		$this->city      = $city;
		$this->county    = $county;
		$this->postcode  = $postcode;
		$this->country   = $country;
	}

	/**
	 * Get address line 1
	 *
	 * @return string
	 */
	public function address_1(): string {
		return $this->address_1;
	}

	/**
	 * Get address line 2
	 *
	 * @return string
	 */
	public function address_2(): string {
		return $this->address_2;
	}

	/**
	 * Get city or Town
	 *
	 * @return string
	 */
	public function city(): string {
		return $this->city;
	}

	/**
	 * Get county or State
	 *
	 * @return string
	 */
	public function county(): string {
		return $this->county;
	}

	/**
	 * Get postcode or Zip
	 *
	 * @return string
	 */
	public function postcode(): string {
		return $this->postcode;
	}

	/**
	 * Get country
	 *
	 * @return string
	 */
	public function country(): string {
		return $this->country;
	}
}
