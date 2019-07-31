<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SecurityBundle\Debug;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Http\Firewall\LegacyListenerTrait;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\VarDumper\Caster\ClassStub;

/**
 * Wraps a security listener for calls record.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 *
 * @internal since Symfony 4.3
 */
final class WrappedListener implements ListenerInterface
{
    use LegacyListenerTrait;

    private $response;
    private $listener;
    private $time;
    private $stub;
    private static $hasVarDumper;

    /**
     * @param callable $listener
     */
    public function __construct($listener)
    {
        $this->listener = $listener;

        if (null === self::$hasVarDumper) {
            self::$hasVarDumper = class_exists(ClassStub::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(RequestEvent $event)
    {
        $startTime = microtime(true);
        if (\is_callable($this->listener)) {
            ($this->listener)($event);
        } else {
            @trigger_error(sprintf('Calling the "%s::handle()" method from the firewall is deprecated since Symfony 4.3, implement "__invoke()" instead.', \get_class($this)), E_USER_DEPRECATED);
            $this->listener->handle($event);
        }
        $this->time = microtime(true) - $startTime;
        $this->response = $event->getResponse();
    }

    /**
     * Proxies all method calls to the original listener.
     */
    public function __call($method, $arguments)
    {
        return $this->listener->{$method}(...$arguments);
    }

    public function getWrappedListener()
    {
        return $this->listener;
    }

    public function getInfo(): array
    {
        if (null === $this->stub) {
            $this->stub = self::$hasVarDumper ? new ClassStub(\get_class($this->listener)) : \get_class($this->listener);
        }

        return [
            'response' => $this->response,
            'time' => $this->time,
            'stub' => $this->stub,
        ];
    }
}
