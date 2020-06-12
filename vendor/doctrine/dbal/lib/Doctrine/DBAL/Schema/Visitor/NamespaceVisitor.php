<?php

namespace Doctrine\DBAL\Schema\Visitor;

/**
 * Visitor that can visit schema namespaces.
 */
interface NamespaceVisitor
{
    /**
     * Accepts a schema namespace name.
     *
     * @param string $namespaceName The schema namespace name to accept.
<<<<<<< HEAD
=======
     *
     * @return void
>>>>>>> ThomasN
     */
    public function acceptNamespace($namespaceName);
}
