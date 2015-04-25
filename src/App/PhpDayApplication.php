<?php

namespace App;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Main application
 */
class PhpDayApplication extends Application
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        $this->register(new TwigServiceProvider(), [
            'twig.path' => $this->getResourceDir('views'),
        ]);

        $this->get('/', function () {
            return $this['twig']->render('index.html.twig');
        });

        $this->get('/{section}', function (Application $app, $section) {
            try {
                return $app['twig']->render(sprintf('%s.html.twig', $section));
            } catch (\Twig_Error_Loader $e) {
                throw new NotFoundHttpException();
            }
        });
    }

    /**
     * Get the path to the given resource
     *
     * @param string $resource
     *
     * @return string
     */
    private function getResourceDir($resource)
    {
        return sprintf('%s/Resources/%s', __DIR__, $resource);
    }
}
