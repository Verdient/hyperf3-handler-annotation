<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\HandlerAnnotation;

use BadMethodCallException;
use Hyperf\Di\Annotation\AbstractAnnotation as AnnotationAbstractAnnotation;
use Override;

/**
 * 抽象处理器注解
 *
 * @author Verdient。
 */
abstract class AbstractHandlerAnnotation extends AnnotationAbstractAnnotation
{
    /**
     * @author Verdient。
     */
    #[Override]
    public function collectClass(string $className): void
    {
        throw new BadMethodCallException('Method collectClass must be implemented by a subclass.');
    }

    /**
     * 标识符
     *
     * @author Verdient。
     */
    abstract public function identifier(): string;
}
