<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingExpatDakar extends Command
{
    protected $signature = 'scrape:expatdakar';
    protected $description = 'Scrape expat-dakar.com for job titles';

    public function handle()
    {
        try {
            $client = new Client();
            $jobListUrl = 'https://www.expat-dakar.com/emploi';
            $response = $client->request('GET', $jobListUrl);
            $html = (string) $response->getBody();
            
            // Affiche le contenu du HTML récupéré pour vérifier
            $this->info('HTML content fetched: ' . substr($html, 0, 2000)); // Affiche plus de contenu pour vérification
            
            $crawler = new Crawler($html);

            // Vérifie si le sélecteur CSS est correct
            $titles = $crawler->filter('.listing-card_header_title');
            if ($titles->count() > 0) {
                $titles->each(function ($node) {
                    $jobTitle = $node->text();
                    $this->info('Job Title: ' . $jobTitle);
                });
                $this->info('Scraping completed.');
            } else {
                $this->error('No job titles found. Please check the CSS selector.');
            }

        } catch (\Exception $e) {
            $this->error('Error during scraping: ' . $e->getMessage());
        }
    }
}
