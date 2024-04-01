<?php

declare(strict_types=1);

namespace Montonio\Structs;

abstract class AbstractStruct
{
    public function __construct(?array $dataArray = null)
    {
        if (is_array($dataArray)) {
            $this->setFromArray($dataArray);
        }

        return $this;
    }

    public function setFromArray($dataArray): void
    {
        foreach ($dataArray as $fieldName => $fieldValue) {
            if (is_array($fieldValue)) {
                $className = __NAMESPACE__ . '\\' . ucfirst($fieldName);
                if (is_a($className, AbstractStruct::class, true)) {
                    $fieldValue = new $className($fieldValue);
                }
            }

            $methodName = 'set' . ucfirst($fieldName);
            if (method_exists($this, $methodName)) {
                $this->{$methodName}($fieldValue);
            }
        }
    }

    public function toArray(): array
    {
        $return = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (!isset($this->{$property})) {
                continue;
            }

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
