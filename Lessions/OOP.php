<?php
class Animal
{
    public $name;
    protected $sound = 'makes a sound'; // protected để lớp con dùng được

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function speak()
    {
        echo $this->name . " " . $this->sound . "\n";
    }
}

class Dog extends Animal
{ // Dog kế thừa từ Animal
    protected $sound = 'barks'; // Ghi đè (override) thuộc tính sound

    public function fetch()
    {
        echo $this->name . " is fetching the ball.\n";
    }

    // Ghi đè phương thức speak (optional)
    // public function speak() {
    //     echo $this->name . " says Woof!\n";
    // }

    // Gọi phương thức của lớp cha
    public function speakLikeParent()
    {
        parent::speak(); // Gọi đến phương thức speak() của lớp Animal
    }
}

$buddy = new Dog('Buddy');
$buddy->speak(); // Output: Buddy barks (sử dụng $sound của Dog)
$buddy->fetch(); // Output: Buddy is fetching the ball.
echo $buddy->name; // Output: Buddy (thừa hưởng thuộc tính public)
// echo $buddy->sound; // LỖI! Không truy cập được protected từ bên ngoài
$buddy->speakLikeParent(); // Output: Buddy barks (Vì speak() của cha dùng $this->sound, mà $this là Dog)
// Nếu muốn nó kêu "makes a sound" thì phải sửa lại logic speak() của cha
// hoặc không override $sound ở lớp con.

$animal = new Animal('Generic Animal');
$animal->speak(); // Output: Generic Animal makes a sound
