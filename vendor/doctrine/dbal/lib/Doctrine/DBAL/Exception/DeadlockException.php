<?php

namespace Doctrine\DBAL\Exception;

/**
 * Exception for a deadlock error of a transaction detected in the driver.
<<<<<<< HEAD
=======
 *
 * @psalm-immutable
>>>>>>> ThomasN
 */
class DeadlockException extends ServerException implements RetryableException
{
}
