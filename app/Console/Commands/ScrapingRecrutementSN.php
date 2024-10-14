<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\offre_emplois;

class ScrapingRecrutementSN extends Command
{
    protected $signature = 'scrape:RSN';
    protected $description = 'Scrape job listings from recrutement.sn';

    public function handle(): void
    {
        $client = new Client();
        $jobListUrl = 'https://recrutement.sn/page/13/?job-title=S%C3%A9n%C3%A9gal';
        $response = $client->request(method: 'GET', uri: $jobListUrl);
        $html = (string) $response->getBody();
        $crawler = new Crawler(node: $html);

        $jobs = [];

        $crawler->filter(selector: 'li.n-job-title-box')->each(closure: function ($node, $i) use (&$jobs, $client): void {
            $jobTitle = $this->extractText(crawler: $node, selector: 'h4 a', name: 'Job title');
            $jobUrl = $this->extractAttr(crawler: $node, selector: 'h4 a', attr: 'href', name: 'Job URL');
            $employer = $this->extractText(crawler: $node, selector: '.company-name a', name: 'Employer');
            $region = $this->extractTextXPath(crawler: $node, xpath: '//i[@class="ti-location-pin"]/following-sibling::a', name: 'Region');
            $sector = $this->extractTextXPath(crawler: $node, xpath: '//i[@class="ti-tag"]/following-sibling::a', name: 'Sector');
            
            // Getting contract type from the sibling element
            $contractTypeNode = $node->nextAll()->filter('li.n-job-short span:contains("Type de contrat")')->first();
            $contractType = $contractTypeNode->count() ? str_replace(search: 'Type de contrat', replace: '', subject: $contractTypeNode->text()) : 'N/A';

            // Fetch job details from the individual job page
            $jobResponse = $client->request(method: 'GET', uri: $jobUrl);
            $jobHtml = (string) $jobResponse->getBody();
            $jobCrawler = new Crawler(node: $jobHtml);

            $experience = $this->extractText(crawler: $jobCrawler, selector: '.n-single-meta-2 li:contains("Expérience professionnelle") strong', name: 'Experience');
            $academicLevel = $this->extractText(crawler: $jobCrawler, selector: '.n-single-meta-2 li:contains("Formation") strong', name: 'Academic level');
            $description = $this->extractDescription(crawler: $jobCrawler, selector: '.n-single-detail');

            $jobData = [
                'titre' => $jobTitle,
                'employeur' => $employer,
                'region' => $region,
                'secteur' => $sector,
                'contrat' => trim(string: $contractType),
                'annee_experience' => $experience,
                'niveau_etude' => $academicLevel,
                'description' => $description,
                'mode_travail' => 'N/A', // ou une autre valeur par défaut
                'date_publication' => null,
                'date_expiration' => null,
            ];

            // Enregistrer les données scrappées dans la base de données
            $this->saveJobData(jobData: $jobData);

            $jobs[] = $jobData;
        });

        $this->info(string: 'les données ont bien été enregistrer dans la base de donnée.');
    }

    private function extractText(Crawler $crawler, string $selector, string $name): ?string
    {
        $node = $crawler->filter(selector: $selector);
        if ($node->count() > 0) {
            return $node->text();
        } else {
            $this->error(string: "Failed to extract {$name}");
            return 'N/A';
        }
    }

    private function extractTextXPath(Crawler $crawler, string $xpath, string $name): ?string
    {
        $node = $crawler->filterXPath(xpath: $xpath);
        if ($node->count() > 0) {
            return $node->text();
        } else {
            $this->error(string: "Failed to extract {$name}");
            return 'N/A';
        }
    }

    private function extractAttr(Crawler $crawler, string $selector, string $attr, string $name): ?string
    {
        $node = $crawler->filter(selector: $selector);
        if ($node->count() > 0) {
            return $node->attr(attribute: $attr);
        } else {
            $this->error(string: "Failed to extract {$name}");
            return null;
        }
    }

    private function extractDescription(Crawler $crawler, string $selector): string
    {
        $description = '';
        $crawler->filter(selector: $selector)->each(closure: function ($node) use (&$description): void {
            $description .= $node->text() . ' '; // Concatenate the text without HTML tags
        });
        return trim(string: $description);
    }

    private function saveJobData(array $jobData): void
    {
        // Créer une nouvelle instance de l'offre d'emploi et sauvegarder dans la base de données
        offre_emplois::create(attributes: $jobData);
    }
}