<?php

namespace HDV\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use HDV\VentesBundle\Entity\Objects;
class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
        ->setName('import:csv')
        ->setDescription('Import objects from CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 390;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();
        $vente = $em->getRepository('HDVVentesBundle:Ventes')->find(2);

        // Processing on each row of data
        foreach($data as $row) {

            $obj = New Objects();
			// Updating info
$fam = $em->getRepository('HDVVentesBundle:Famille')->find($row['famille']);

            $obj->setCodevac($vente);
            $obj->setCodedossier($row['codedossier']);
            $obj->setDescription($row['description']);
            $obj->setOrdre($row['ordre']);
            $obj->setEstimbasse($row['estb']);
            $obj->setEstimhaute($row['esth']);
            $obj->setFamille($fam);

        $obj->setImage($row['image']);
			// Persisting the current user
            $em->persist($obj);

			// Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
				// Detaches all objects from Doctrine for memory save
                $em->clear();

				// Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of objects imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

		// Flushing and clear data on queue
        $em->flush();
        $em->clear();

		// Ending the progress bar process
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        $fileName = 'web/import.csv';

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert($fileName, ';');

        return $data;
    }

}
