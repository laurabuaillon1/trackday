<?php

use App\Entity\Bike;
use PHPUnit\Framework\TestCase;

class BikeTest extends TestCase{

    //First test nickname = true
    public function testGetName(): void{
        $bike = new Bike();
        $bike->setNickname('Ma moto');
        $this->assertSame('Ma moto',$bike->getNickname());//same value and type
    }


    //Second test color = true
    public function testGetColor(): void{
        $bike = new Bike();
        $bike->setColor('Bleu');
        $this->assertSame('Bleu',$bike->getColor());
    }

    //Third test mileage = false
    public function testGetMileage(): void{
        $bike = new Bike();
        $bike->setMileage('15000');
        $this->assertSame('20000',$bike->getMileage());
    }
}