<?php

declare(strict_types=1);

namespace Montonio\Exception;

/**
 * Exception for network/transport failures.
 *
 * Prefer catching this class over the deprecated CurlErrorException.
 */
class TransportException extends CurlErrorException {}
