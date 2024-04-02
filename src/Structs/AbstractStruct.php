<?php

declare(strict_types=1);

namespace Montonio\Structs;

use ReflectionMethod;
use ReflectionNamedType;

abstract class AbstractStruct
{
    public function __construct(?array $dataArray = null)
    {
        if (is_array($dataArray)) {
            $this->setFromArray($dataArray);
        }
    }

    public function setFromArray($dataArray): self
    {
        foreach ($dataArray as $fieldName => $fieldValue) {
            $methodName = 'set' . ucfirst($fieldName);

            // Skip null values, empty arrays, and if setter doesn't exist in this structure
            if (
                is_null($fieldValue)
                || !method_exists($this, $methodName)
                || (is_array($fieldValue) && empty($fieldValue))
            ) {
                continue;
            }


            if (is_array($fieldValue)) {
                $method = new ReflectionMethod($this, $methodName);
                $type = ($method->getParameters()[0])->getType();

                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                    // If the parameter has a type definition, and it's not builtin, it's probably a class
                    $typeName = $type->getName();

                    if (is_a($typeName, AbstractStruct::class, true)) {
                        // If it's our structure class, let's initialize it
                        $fieldValue = new $typeName($fieldValue);
                    }
                }
            }

            $this->{$methodName}($fieldValue);
        }

        return $this;
    }

    public function toArray(): array
    {
        $return = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (!isset($this->{$property})) {
                continue;
            }

            // Getting the property using getter
            $methodName = 'get' . ucfirst($property);
            $value = method_exists($this, $methodName)
                ? $this->{$methodName}()
                : $value;

            // If value is a structure, unpack it
            if ($value instanceof AbstractStruct) {
                $value = $value->toArray();
            } elseif (is_array($value)) {
                foreach ($value as $valueKey => $valueValue) {
                    $value[$valueKey] = $valueValue instanceof AbstractStruct
                        ? $valueValue->toArray()
                        : $valueValue;
                }
            }

            $return[$property] = $value;
        }

        return $return;
    }
}
