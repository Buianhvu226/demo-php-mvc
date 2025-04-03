<?php

class Counter
{
    public static $count = 0;

    public static function increment()
    {
        self::$count++;
    }

    public static function getCount()
    {
        return self::$count;
    }
}

echo "Initial count: " . Counter::getCount() . "\n"; // Output: 0
Counter::increment();
$myCounter1 = new Counter();
$myCounter1->increment();
echo "Count after incrementing: " . Counter::getCount() . "\n"; // Output: 2
$myCounter2 = new Counter();
$myCounter2->increment();
echo "Count after incrementing: " . Counter::getCount() . "\n"; // Output: 3

echo "======================\n";

class StringUtil
{
    public static function reverseString($str)
    {
        return strrev($str);
    }

    public static function createUser()
    {
        echo "User created\n";
    }
}

echo StringUtil::reverseString("Hello World") . "\n"; // Output: dlroW olleH
StringUtil::createUser(); // Output: User created

class Test
{
    public function doSomething()
    {
        $reverse = StringUtil::reverseString("Hello World");
        echo $reverse . "\n"; // Output: dlroW olleH
    }
}
echo "======================\n";

class Dad
{
    protected static $name = 'Parent';

    public static function getName()
    {
        echo "self::\$name: " . self::$name . "\n"; // Output: Parent
        echo "static::\$name: " . static::$name . "\n"; // Output: Parent
    }
}

class Son extends Dad
{
    protected static $name = "Child";
}

Dad::getName(); // Output: Parent Parent
Son::getName(); // Output: Parent Child
