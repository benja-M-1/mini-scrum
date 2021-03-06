<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class ProjectController extends Controller
{
    /**
     * @Extra\Route("/{project}", name="project_show")
     * @Extra\ParamConverter("project", options={ "mapping": { "project": "slug" } })
     * @Extra\Template()
     */
    public function showAction(Project $project = null)
    {
        if (null == $project) {
            $project = $this->getUser()->getSelectedProject();
            $url     = $this->generateUrl('project_show', array('project' => $project->getSlug()));

            return $this->redirect($url);
        }

        return array('project' => $project);
    }

    /**
     * @Extra\Template()
     */
    public function scrumBarAction($project, $activeTab)
    {
        $project = $this->getDoctrine()
            ->getRepository('MiniTeamScrumBundle:Project')
            ->findOneBySlug($project);

        $usRepo = $this->getDoctrine()->getRepository('MiniTeamScrumBundle:UserStory');

        //TODO do it in one request
        $nb_product_backlog = $usRepo->countUserStoriesWithStatus($project, 'product-backlog');
        $nb_sprint_backlog  = $usRepo->countUserStoriesWithStatus($project, 'sprint-backlog');
        $nb_doing           = $usRepo->countUserStoriesWithStatus($project, 'doing');
        $nb_blocked         = $usRepo->countUserStoriesWithStatus($project, 'blocked');
        $nb_to_validate     = $usRepo->countUserStoriesWithStatus($project, 'to-validate');
        $nb_done            = $usRepo->countUserStoriesWithStatus($project, 'done');

        return array(
            'project'            => $project,
            'activeTab'          => $activeTab,
            'nb_product_backlog' => $nb_product_backlog,
            'nb_sprint_backlog'  => $nb_sprint_backlog,
            'nb_doing'           => $nb_doing,
            'nb_blocked'         => $nb_blocked,
            'nb_to_validate'     => $nb_to_validate,
            'nb_done'            => $nb_done,
        );

    }

}
