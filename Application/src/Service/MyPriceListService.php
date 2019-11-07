<?php


namespace Application\Service;


class MyPriceListService
{
    /** @var string */
    private $variable;

    /**
     * MyPriceListService constructor.
     * @param string $variable
     */
    public function __construct(string $variable)
    {
        echo 1;
        $this->variable = $variable;
    }

    /**
     * @return string
     */
    public function getHello(): string
    {
        return 'Hello!';
    }
}