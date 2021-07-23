<?php

declare(strict_types=1);

/**
 * Customer model
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer Customer
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Customer;

use PinkCrab\WC_Pink_Pos\Customer\Customer_Address;

class Customer {

	/**
	 * Remote product id.
	 *
	 * @var int|null
	 */
	protected $customer_id;

	/**
	 * Customer name.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Customer Email.
	 *
	 * @var string
	 */
	protected $email = '';

	/**
	 * Customer phone.
	 *
	 * @var string
	 */
	protected $phone = '';

	/**
	 * All accepted marketing types.
	 *
	 * @var string[]
	 */
	protected $marketing = array();

	/**
	 * Billing address
	 *
	 * @var Customer_Address|null
	 */
	protected $billing_address;

	/**
	 * Shipping address.
	 *
	 * @var Customer_Address|null
	 */
	protected $delivery_address;

	/**
	 * Customer notes.
	 *
	 * @var string[]
	 */
	protected $notes = array();


	public function __construct( int $customer_id = null ) {
		$this->customer_id = $customer_id;
	}


	/**
	 * Get remote product id.
	 *
	 * @return int|null
	 */
	public function get_customer_id(): ?int {
		return $this->customer_id;
	}

	/**
	 * Get customer name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Set customer name.
	 *
	 * @param string $name  Customer name.
	 *
	 * @return self
	 */
	public function set_name( string $name ): self {
		$this->name = $name;
		return $this;
	}

	/**
	 * Get customer Email.
	 *
	 * @return string
	 */
	public function get_email(): string {
		return $this->email;
	}

	/**
	 * Set customer Email.
	 *
	 * @param string $email  Customer Email.
	 *
	 * @return self
	 */
	public function set_email( string $email ): self {
		$this->email = $email;
		return $this;
	}

	/**
	 * Get customer phone.
	 *
	 * @return string
	 */
	public function get_phone(): string {
		return $this->phone;
	}

	/**
	 * Set customer phone.
	 *
	 * @param string $phone  Customer phone.
	 *
	 * @return self
	 */
	public function set_phone( string $phone ): self {
		$this->phone = $phone;
		return $this;
	}

	/**
	 * Get billing address
	 *
	 * @return Customer_Address
	 */
	public function get_billing_address(): Customer_Address {
		return $this->billing_address ?? new Customer_Address( '', '', '', '', '', '' );
	}

	/**
	 * Set billing address
	 *
	 * @param Customer_Address|null $billing_address  Billing address
	 *
	 * @return self
	 */
	public function set_billing_address( Customer_Address $billing_address ): self {
		$this->billing_address = $billing_address;
		return $this;
	}

	/**
	 * Get shipping address.
	 *
	 * @return Customer_Address
	 */
	public function get_delivery_address(): Customer_Address {
		return $this->delivery_address ?? new Customer_Address( '', '', '', '', '', '' );;
	}

	/**
	 * Set shipping address.
	 *
	 * @param Customer_Address|null $delivery_address  Shipping address.
	 *
	 * @return self
	 */
	public function set_delivery_address( Customer_Address $delivery_address ): self {
		$this->delivery_address = $delivery_address;
		return $this;
	}

	/**
	 * Get customer notes.
	 *
	 * @return string[]
	 */
	public function get_notes(): array {
		return $this->notes;
	}

	/**
	 * Set customer notes.
	 *
	 * @param string[] $notes  Customer notes.
	 *
	 * @return self
	 */
	public function set_notes( array $notes ): self {
		$this->notes = $notes;
		return $this;
	}

	/**
	 * Get all accepted marketing types.
	 *
	 * @return string[]
	 */
	public function get_marketing(): array {
		return $this->marketing;
	}

	/**
	 * Set all accepted marketing types.
	 *
	 * @param string[] $marketing  All accepted marketing types.
	 *
	 * @return self
	 */
	public function set_marketing( array $marketing ): self {
		$this->marketing = $marketing;
		return $this;
	}

}
