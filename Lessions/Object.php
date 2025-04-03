<?php

class Car {
    public $color;
    public $model;
    public $year;
    private $availableColor = ['Red', 'Blue', 'Green', 'Black', 'White'];
    private $availableModel = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes'];

    public function getDetails() {
        return "Car Model: {$this->model}, Color: {$this->color}, Year: {$this->year}";
    }

    public function setColor($color) {
        if (in_array($color, $this->availableColor)) {
            $this->color = $color;
        } else {
            echo "Invalid color!";
        }
    }

    public function isFamousModel() {
        if (in_array($this->model, $this->availableModel)) {
            return true;
        } else {
            return false;
        }
    }
}

$myCar = new Car();
$myCar->setColor("Red"); // Gọi phương thức setColor để thiết lập màu sắc
$myCar->model = "Toyota";   
$myCar->year = 2020;
echo $myCar->getDetails(); // Kết quả: Car Model: Toyota, Color: Red, Year: 2020
echo $myCar->isFamousModel() ? " - Famous Model" : " - Not a Famous Model"; // Kết quả: Famous Model
echo "<br>";
echo "===================\n";
?>