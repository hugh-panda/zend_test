<?php


namespace Application\Factory;


use Application\Service\MyPriceListService;


class MyPriceListServiceFactory
{
    /**
     * @param string $variable
     * @return MyPriceListService
     */
    public function __invoke(string $variable) : MyPriceListService
    {
        return new MyPriceListService($variable);
    }

}