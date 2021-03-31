<?php 
  trait createDetails {
    
    // get properties's values of an object and push to an array
    private function createDetails(): array {
      $details = [];
      foreach ($this as $property => $value) {
        array_push($details, $value);
      }
      return $details;
    }
  }

  trait upercaseString {

    // change string in $values to uppercase
    private function upercaseString(array $values): array {
      $newValues = [];
      foreach ($values as $key => $value) {
        if (is_string($value) == 1) {
          $newValue = strtoupper($value);
          array_push($newValues, $newValue);
        }
        else {
          array_push($newValues, $value);
        }
      }
      return $newValues;
    }      
  }

 ?>