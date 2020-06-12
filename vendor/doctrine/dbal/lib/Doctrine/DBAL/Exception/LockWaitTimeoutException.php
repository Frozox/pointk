<?php

namespace Doctrine\DBAL\Exception;

/**
 * Exception for a lock wait timeout error of a transaction detected in the driver.
<<<<<<< HEAD
=======
 *
 * @psalm-immutable
>>>>>>> ThomasN
 */
class LockWaitTimeoutException extends ServerException implements RetryableException
{
}
