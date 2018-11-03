<?php
  class CartItem {
      protected $name;
      protected $price;
      protected $quantity = 1;

      public function __construct($name, $price)
      {
          $this->name = $name;
          $this->price = $price;
      }

      public function display()
      {
          return sprintf("Name: %s, Price: $%.2f, Quantity: %d, Total: $%.2f", $this->name, $this->price, $this->quantity, $this->calculateCost());
      }

      public function calculateCost()
      {
          return $this->price * $this->quantity;
      }
      public function getName()
      {
          return $this->name;
      }

      public function updateQuantity()
      {
          $this->quantity++;
      }
  }
?>