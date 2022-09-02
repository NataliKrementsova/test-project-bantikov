# test-project-bantikov
Test project for Bantikov company.

### Installation

run the following command to install necessary dependencies

```
composer install
```

### project usage notes
You can change glob_region param to switch the search area.
Use the current language to get the relevant info else you'll get the result for default region.

```
http://127.0.0.1/?user_lang=rus&glob_region=asia
```
The result list will contain the data for the default continent 'Европа'.

```
http://127.0.0.1/?user_lang=eng&glob_region=America
```
The result list will contain the data for the detected continent 'North America'.