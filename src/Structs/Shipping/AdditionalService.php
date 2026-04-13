<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class AdditionalService extends AbstractStruct
{
    protected string $code;
    protected AdditionalServiceParams $params;

    public function getCode(): ?string
    {
        return $this->code ?? null;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getParams(): ?AdditionalServiceParams
    {
        return $this->params ?? null;
    }

    public function setParams(AdditionalServiceParams $params): self
    {
        $this->params = $params;

        return $this;
    }
}
