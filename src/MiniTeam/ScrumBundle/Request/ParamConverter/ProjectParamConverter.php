<?php

namespace MiniTeam\ScrumBundle\Request\ParamConverter;

use Doctrine\ORM\EntityManager;
use MiniTeam\ScrumBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

/**
 * ProjectParamConverter description
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class ProjectParamConverter implements ParamConverterInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                                $request
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface $configuration
     *
     * @return bool
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function apply(Request $request, ConfigurationInterface $configuration)
    {
        $repository = $this->manager->getRepository('MiniTeamScrumBundle:Project');

        $project = $repository->findOneBySlug($request->attributes->get('project'));

        if (!$project instanceof Project) {
            throw new NotFoundHttpException('The project you are looking for does not exist.');
        }


        $request->attributes->set($configuration->getName(), $project);

        return true;
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface $configuration
     *
     * @return bool
     */
    public function supports(ConfigurationInterface $configuration)
    {
        return 'MiniTeam\ScrumBundle\Entity\Project' == $configuration->getClass();
    }
}
