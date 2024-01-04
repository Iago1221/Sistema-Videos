<?php

namespace src\Infra;

abstract class Controller
{
    abstract function getAll(): void;
    abstract function getForId(int $id): void;
    abstract function add(): void;
    abstract function update(int $id): void;
    abstract function delete(int $id): void;

    protected function getRequest() {
        $request = file_get_contents('php://input');
        $requestData = json_decode($request, true);
        return $requestData;
    }

    /**
     * @param object $model
     * @return array
     */
    public static function mapEntityToArray(object $model) {
        $result = [];

        $reflectionClass = new \ReflectionClass($model);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $getterMethod = ucfirst($propertyName);

            if (method_exists($model, $getterMethod)) {
                $propertyType = $property->getType();
                if ($propertyType && $propertyType->getName() !== 'DateTime' && !$propertyType->isBuiltin()) {
                    $getterMethodName = $getterMethod . "Titulo";
                    $value = $model->$getterMethodName();
                    $result[$propertyName] = ['id' => $model->$getterMethod()->id(), 'titulo' => $value];
                } else {
                    $value = $model->$getterMethod();
                    $result[$propertyName] = $value;
                }
            }
        }

        return $result;
    }
}