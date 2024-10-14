<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\offre_emplois; 

class ScrapingWiijob extends Command
{
    protected $signature = 'scrape:wiijob';
    protected $description = 'Script de scraping des offres du site wiijob.com ';

    public function handle(): void
    {
        $client = new Client();
        $jobListUrl = 'https://wiijob.com/offres-emploi/?filter-location=160';
        $response = $client->request(method: 'GET', uri: $jobListUrl);
        $html = (string) $response->getBody();
        $crawler = new Crawler(node: $html);

        $jobs = [];

        $crawler->filter(selector: '.job-title a')->each(closure: function ($node, $i) use (&$jobs, $client, $crawler): void {
            $jobTitle = $node->text();
            $jobUrl = $node->attr('href');

            // Récupérer l'employeur
            $employer = $crawler->filter(selector: '.employeur_name_joblist a')->eq(position: $i)->text();

            $jobResponse = $client->request(method: 'GET', uri: $jobUrl);
            $jobHtml = (string) $jobResponse->getBody();
            $jobCrawler = new Crawler(node: $jobHtml);

            $publicationDate = $this->convertDateFormat(dateString: $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Publié le") + .value'));
            $city = $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Ville") + .value .job-location');
            $expirationDate = $this->convertDateFormat(dateString: $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Expire le") + .value'));
            $experience = $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Expérience") + .value');
            $sector = $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Secteur d\'activité") + .value');
            $academicLevel = $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Niveau académique") + .value');
            $workMode = $this->extractText(crawler: $jobCrawler, selector: '.job-detail-detail .list .details .text:contains("Temps de travail") + .value');
           
            // Récupérer le type de contrat
            $contractType = $this->extractText(crawler: $jobCrawler, selector: '.job-type.with-title .type-job');

            // Récupérer la description des missions et du profil recherché
            $missions = $this->extractListItems(crawler: $jobCrawler, selector: '.job-detail-description h5:contains("Missions") + ul li');
            $profile = $this->extractListItems(crawler: $jobCrawler, selector: '.custom-field-data.job-profile-recherche h5:contains("Profil recherché") + .content ul li');
            $description = "Missions: " . implode(separator: ", ", array: $missions) . " | Profil recherché: " . implode(separator: ", ", array: $profile);

            $jobData = [
                'titre' => $jobTitle,
                'region' => $city,
                'secteur' => $sector,
                'niveau_etude' => $academicLevel,
                'annee_experience' => $experience,
                'contrat' => $contractType,
                'mode_travail' => $workMode,
                'date_publication' => $publicationDate,
                'date_expiration' => $expirationDate,
                'employeur' => $employer,
                'description' => $description,
            ];

            // Enregistrer les données scrappées dans la base de données
            $this->saveJobData(jobData: $jobData);
        });

        $this->info(string: 'Scraping completed.');
    }

    private function extractText(Crawler $crawler, string $selector): ?string
    {
        $node = $crawler->filter(selector: $selector);
        return $node->count() > 0 ? $node->text() : 'N/A';
    }

    private function extractListItems(Crawler $crawler, string $selector): array
    {
        $items = [];
        $crawler->filter(selector: $selector)->each(closure: function ($node) use (&$items): void {
            $items[] = $node->text();
        });
        return $items;
    }

    private function convertDateFormat($dateString): string|null
    {
        $date = \DateTime::createFromFormat(format: 'd/m/Y', datetime: $dateString);
        return $date ? $date->format(format: 'Y-m-d') : null;
    }

    private function saveJobData(array $jobData): void
    {
        // Créer une nouvelle instance de l'offre d'emploi et sauvegarder dans la base de données
        offre_emplois::create(attributes: $jobData);
    }
}