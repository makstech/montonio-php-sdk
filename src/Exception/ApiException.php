<?php

declare(strict_types=1);

namespace Montonio\Exception;

/**
 * Base exception for all Montonio API HTTP errors.
 *
 * Prefer catching this class (or its subclasses) over the deprecated RequestException.
 */
class ApiException extends RequestException {}
