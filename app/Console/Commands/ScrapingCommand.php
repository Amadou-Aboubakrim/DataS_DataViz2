<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingCommand extends Command
{
    protected $signature = 'scrape:wiijob';
    protected $description = 'Scrape wiijob.com for job details';

    public function handle()
    {
        $client = new Client();
        $jobListUrl = 'https://wiijob.com/offres-emploi/?jobs_ppp=-1&filter-location=130';
        $response = $client->request('GET', $jobListUrl);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        $jobs = [];

        $crawler->filter('.job-title a')->each(function ($node, $i) use (&$jobs, $client) {
            $jobTitle = $node->text();
            $jobUrl = $node->attr('href');

            $jobResponse = $client->request('GET', $jobUrl);
            $jobHtml = (string) $jobResponse->getBody();
            $jobCrawler = new Crawler($jobHtml);

            $publicationDate = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Publié le") + .value');
            $city = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Ville") + .value .job-location');
            $expirationDate = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Expire le") + .value');
            $experience = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Expérience") + .value');
            $sector = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Secteur d\'activité") + .value');
            $academicLevel = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Niveau académique") + .value');
            $workTime = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Temps de travail") + .value');
            $workMode = $this->extractText($jobCrawler, '.job-detail-detail .list .details .text:contains("Mode de travail") + .value');

            $jobs[] = [
                'title' => $jobTitle,
                'publicationDate' => $publicationDate,
                'city' => $city,
                'expirationDate' => $expirationDate,
                'experience' => $experience,
                'sector' => $sector,
                'academicLevel' => $academicLevel,
                'workTime' => $workTime,
                'workMode' => $workMode,
            ];
        });

        foreach ($jobs as $job) {
            $this->info('Titre: ' . $job['title']);
            $this->info('Publication Date: ' . $job['publicationDate']);
            $this->info('Région: ' . $job['city']);
            $this->info('Date_expiration: ' . $job['expirationDate']);
            $this->info('Année_d\'Experience: ' . $job['experience']);
            $this->info('Secteur_d\'activité: ' . $job['sector']);
            $this->info('Niveau_d\'étude: ' . $job['academicLevel']);
            $this->info('Mode_travail: ' . $job['workTime']);
            $this->info('Work Mode: ' . $job['workMode']);
            $this->info('---');
        }

        $this->info('Scraping completed.');
    }

    private function extractText(Crawler $crawler, string $selector): ?string
    {
        $node = $crawler->filter($selector);
        return $node->count() > 0 ? $node->text() : 'N/A';
    }
}