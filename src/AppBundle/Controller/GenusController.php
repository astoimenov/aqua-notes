<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GenusController extends BaseController
{
    /**
     * Entity manager.
     *
     * @var [type]
     */
    protected $manager;

    /**
     * Doctrine entity repository.
     *
     * @var [type]
     */
    protected $repository;

    /**
     * @Route("/genus", name="genus_index")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $genuses = $this->getRepository(Genus::class)->findAllPublished();

        return $this->render('AppBundle:Genus:index.html.twig', [
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/new", name="genus_store")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function storeAction()
    {
        $genus = new Genus();
        $genus->setName('Octopuse'.rand(1, 100));
        $genus->setSubFamily('Octopodinae'.rand(1, 100));
        $genus->setSpeciesCount(rand(100, 99999));

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));

        $note->setGenus($genus);

        $manager = $this->getManager();

        $manager->persist($genus);
        $manager->persist($note);
        $manager->flush();

        return new Response('<html><body>Genus created!</body></html>');
    }

    /**
     * @Route("/genus/{name}", name="genus_show")
     * @Method("GET")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Genus $genus)
    {
        $recentNotes = $this->getRepository(GenusNote::class)
            ->findAllRecentNotesForGenus($genus);
        $markdownParser = $this->get('app.markdown_transformer');
        $funFact = $markdownParser->parse($genus->getFunFact());

        return $this->render('AppBundle:Genus:show.html.twig', [
            'genus' => $genus,
            'funFact' => $funFact,
            'recentNotesCount' => count($recentNotes),
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function getNotesAction(Genus $genus)
    {
        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y'),
            ];
        }

        $data = [
            'notes' => $notes,
        ];

        return new JsonResponse($data);
    }
}
