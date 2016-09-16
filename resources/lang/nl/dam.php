<?php

return [
    'project' => [
        'archive_confirm' => 'Weet je zeker dat je dit project wil archiveren?',
        'archive' => 'Archiveer project',
        'archived' => 'Project succesvol gearchiveerd.',
        'create_invoice' => 'Project factureren',
        'customer' => 'Klant',
        'description' => 'Projectomschrijving',
        'destroy_confirm' => 'Weet je zeker dat je dit project wil verwijderen? Alle urenregistraties gaan ook verloren.',
        'destroy' => 'Verwijder project',
        'edit' => 'Bewerk project',
        'name' => 'Projectnaam',
        'new' => 'Nieuw project',
        'notify_after' => 'Geef een melding na.. (uren)',
        'project' => 'Project',
        'projects' => 'Projecten',
        'reopened' => 'Project succesvol heropend.',
        'shareability' => ['disable' => 'Schakel deelbaarheid uit',
                            'disabled' => 'Deelbaarheid succesvol uitgeschakeld.',
                            'enable' => 'Genereer deelbare link',
                            'enabled' => 'Project succesvol deelbaar gemaakt.',
                            'shareable_link' => 'Deelbare link',
        ],
        'updated' => 'Project succesvol geüpdatet.',
        'worked_hours' => 'Gewerkte uren'
    ],

    'timesheet' => [
        'add' => 'Uren registreren',
        'cannot_edit' => 'Lopende uren kunnen niet worden bewerkt.',
        'currently_working_on' => 'Momenteel bezig met',
        'deleted' => 'Uren succesvol verwijderd.',
        'description' => 'Omschrijving van de werkzaamheden',
        'destroy' => 'Uren verwijderen',
        'destroy_confirm' => 'Weet je zeker dat je deze uren wil verwijderen?',
        'destroyed' => 'Uren succesvol verwijderd.',
        'edit' => 'Uren bewerken',
        'end' => ['date' => 'Einddatum',
                  'time' => 'Eindtijd'
        ],
        'notification' => [
            'greeting' => 'Hoi!',
            'intro' => 'Het project :projectName is over de aangegeven :hours u(u)r(en) heengegaan.',
            'subject' => 'Urenmelding :projectName',
            'to_timesheet' => 'Ga naar het urenoverzicht',
            'turn_off' => 'Om de meldingen uit te zetten kun je het project bewerken en \'0\' invoeren bij \'Geef melding na..\'.'
        ],
        'ongoing' => 'Lopend',
        'save' => 'Uren opslaan',
        'start' => ['date' => 'Startdatum',
                    'time' => 'Starttijd'
        ],
        'start_timer' => 'Timer starten',
        'started' => 'Timer succesvol gestart.',
        'stored' => 'Uren succesvol toegevoegd aan het project.',
        'timesheet' => 'Urenregistratie',
        'total' => 'Totaal',
        'updated' => 'Uren succesvol geüpdatet'
    ],

    'customer' => [
        'address' => 'Adres',
        'cannot_destroy' => 'Klanten die gekoppeld zijn aan facturen en/of projecten kunnen niet worden verwijderd.',
        'chamber_of_commerce' => 'KVK-nummer',
        'city' => 'Plaats',
        'company_name' => 'Bedrijfsnaam',
        'contact_information' => 'Contactinformatie',
        'contact_person' => 'Contactpersoon',
        'customer' => 'Klant',
        'customers' => 'Klantenbestand',
        'delete' => 'Klant verwijderen',
        'destory_explained' => 'Weet je zeker dat je deze klant wil verwijderen? Het is niet meer mogelijk om facturen en projecten aan deze klant te koppelen.',
        'destroyed' => 'Klant succesvol verwijderd.',
        'edit' => 'Klant bewerken',
        'effective_date' => 'Ingangsdatum',
        'email_address' => 'E-mailadres',
        'new' => 'Nieuwe klant',
        'only_incoming' => 'Alleen weergeven bij inkomende facturen',
        'phone_number' => 'Telefoonnummer',
        'postal_code' => 'Postcode',
        'stored' => 'Nieuwe klant succesvol opgeslagen.',
        'updated' => 'Klant succesvol geüpdatet.',
        'vat_number' => 'BTW-nummer'
    ],

    'invoice' => [
        'add_details' => 'Regel toevoegen',
        'addressor' => 'Geadresseerde',
        'all' => 'Alle facturen',
        'amount' => 'Bedrag',
        'created' => 'Factuur succesvol aangemaakt.',
        'createForCustomer' => 'Factuur voor klant',
        'customer_information' => 'Klantgegevens',
        'date' => 'Factuurdatum',
        'description' => 'Omschrijving',
        'details' => 'Factuurinformatie',
        'due_date' => 'Vervaldatum',
        'edit' => 'Factuur bewerken',
        'error' => [
            'already_paid' => 'Je kunt deze factuur niet markeren als betaald, omdat deze al is gemarkeerd als betaald.',
            'edit_already_paid' => 'Je kunt deze factuur niet bewerken, omdat deze al betaald is.'
        ],
        'generate' => 'Factuur aanmaken',
        'get-pdf' => 'PDF Genereren',
        'incoming' => [
            'invoice' => 'Ontvangen factuur',
            'invoices' => 'Ontvangen facturen',
            'only_incoming' => 'Alleen inkomende',
            'unpaid' => 'Openstaande verschuldigde facturen'
        ],
        'invoice' => 'Factuur',
        'invoices' => 'Facturen',
        'mark_as_paid' => 'Markeren als betaald',
        'new_incoming' => 'Nieuwe inkomende factuur',
        'new' => 'Nieuwe factuur',
        'no_project' => 'Niet gekoppeld',
        'not_paid' => 'Nog niet betaald',
        'number' => 'Factuurnummer',
        'outgoing' => 'Verstuurde factuur',
        'over' => 'over',
        'paid_at' => 'Betaald op',
        'pdf' => [
            'chamber_of_commerce' => 'KVK',
            'vat' => 'BTW',
            'phone_number' => 'T',
            'email_address' => 'E',
            'website' => 'W',
            'iban' => 'IBAN',
        ],
        'specification' => 'Specificatie',
        'subtotal' => 'Subtotaal',
        'successfully_paid' => 'Factuur succesvol gemarkeerd als betaald.',
        'total_due' => 'Totaalbedrag',
        'totals' => 'Totalen',
        'unpaid' => 'Openstaande facturen',
        'updated' => 'Factuur succesvol geüpdatet.',
        'vat_percentage' => 'BTW-percentage'
    ],

    'dashboard' => [
        'dashboard' => 'Dashboard',
        'financial_overview' => 'Financieel overzicht',
        'overview' => 'Overzicht'
    ],

    'financial' => [
        'quarter' => [
            '1' => '1e kwartaal',
            '2' => '2e kwartaal',
            '3' => '3e kwartaal',
            '4' => '4e kwartaal'
        ]
    ],

    'general' => [
        'add' => 'Toevoegen',
        'archived' => 'Gearchiveerd',
        'back' => 'Ga terug',
        'contact_information' => 'Contactinformatie',
        'destroy' => 'Verwijderen',
        'error' => ['validation' => 'Eén of meerdere dingen voldoen niet aan de volgende eisen:'],
        'misc' => 'Overig',
        'more-information' => 'Meer informatie',
        'next' => 'Volgende',
        'no_data' => 'Er zijn geen gegevens gevonden.',
        'other' => 'Overige',
        'overview' => 'Overzicht',
        'save' => 'Opslaan'
    ],

    'menu' => [
        'customer' => 'Klantenbestand',
        'home' => 'Home',
        'invoices' => 'Facturen',
        'lock' => 'Vergrendelen',
        'projects' => 'Projecten',
        'settings' => 'Instellingen'
    ],

    'auth' => [
        'authenticate' => 'Authenticeren',
        'emailaddress' => 'E-mailadres',
        'g2f_invalid' => 'De opgegeven authenticatiecode is niet correct.',
        'invalid' => 'De combinatie van de opgegeven gebruikersnaam en wachtwoord is niet correct.',
        'locked_explained' => 'Het administratiepaneel is momenteel vergrendeld. Ontgrendelen kan door het wachtwoord van het onderstaande account in te voeren. Je kunt er ook voor kiezen om het uit te loggen.',
        'locked' => 'Vergrendeld',
        'login' => 'Inloggen',
        'logout' => 'Uitloggen',
        'password_confirmation' => 'Wachtwoord (controle)',
        'password' => 'Wachtwoord',
        'remember_me' => 'Onthoud mij',
        'response_code' => 'Verificatiecode',
        'two_factorauthentication' => 'Tweestapsverificatie',
        'unlock' => 'Ontgrendelen'
    ],

    'settings' => [
        'account' => 'Accountgegevens',
        'change_password' => 'Wachtwoord wijzigen',
        'change_username' => 'Gebruikersnaam wijzigen',
        'company_address' => 'Adres',
        'company_bank_account_number' => 'IBAN',
        'company_chamber_of_commerce' => 'KvK-nummer',
        'company_city' => 'Plaats',
        'company_effective_date' => 'Ingangsdatum',
        'company_email_address' => 'E-mailadres',
        'company_invoice_template' => 'Factuur sjabloon',
        'company_name' => 'Bedrijfsnaam',
        'company_phone_number' => 'Telefoonnummer',
        'company_postal_code' => 'Postcode',
        'company_saved' => 'Bedrijfsgegevens succesvol opgeslagen.',
        'company_vat_number' => 'BTW-nummer',
        'company_website' => 'Website',
        'company' => 'Bedrijfsgegevens',
        'current_password' => 'Huidig wachtwoord',
        'location_data' => 'Vestigingsgegevens',
        'new_password_confirmation' => 'Nieuw wachtwoord (controle)',
        'new_password' => 'Nieuw wachtwoord',
        'other_data' => 'Overige gegevens',
        'password_not_the_same' => 'De opgegeven wachtwoorden komen niet overeen.',
        'two_factor_authentication' => [
            'off' => 'Tweestapsverificatie is uitgeschakeld.',
            'on' => 'Tweestapsverificatie is ingeschakeld.',
            'steps' => [
                '1' => 'Download de Google Authenticator-app uit de <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Google Play Store</a> of <a href="https://itunes.apple.com/nl/app/google-authenticator/id388497605" target="_blank">Apple AppStore</a>.',
                '2' => 'Voeg onderstaande QR-code toe aan de app.'
            ],
            'turn_off' => 'Tweestapsverificatie uitschakelen',
            'turn_on' => 'Tweestapsverificatie inschakelen',
            'turned_off' => 'Tweestapsverificatie succesvol uitgeschakeld.',
            'turned_on' => 'Tweestapsverificatie succesvol ingeschakeld.',
            'two_factor_authentication' => 'Tweestapsverificatie'
        ],
        'updated_password' => 'Wachtwoord succesvol geüpdatet.',
        'updated_username' => 'Gebruikersnaam succesvol geüpdatet.',
        'vat' => [
            'add' => 'BTW-percentage toevoegen',
            'added' => 'BTW-percentage succesvol toegevoegd.',
            'destroyed' => 'BTW-percentage succesvol verwijderd.',
            'vat_percentages' => 'BTW-percentages'
        ]
    ],

    'setup' => [
        'setup' => 'Installatie'
    ]

];
