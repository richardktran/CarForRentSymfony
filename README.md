# 🥇About the project

**The car for rent project** is built to help people who want to rent a car to travel, picnic, or do whatever. As a
person who wants to rent a car, they just find the car they want and make a contract online with the owner of this car.

**The** **car for rent project** is written by Symfony version 6.1 with the instruction of **Mr. Bang
Dinh** and **Mr. Tinh Le**

# 🎉 Getting started

## Setup Environment

- Follow this article to install Nginx in Ubuntu
  20.04: [Click here](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04)
- Create an account to use the S3 service in AWS.


Requirements
------------

* PHP 8.1 or higher;
* PDO-MySQL PHP extension enabled;
* and the [usual Symfony application requirements][2].

Installation
------------

[Download Symfony][4] to install the `symfony` binary on your computer and run
this command:

```bash
$ symfony new --demo my_project
```

Alternatively, you can use Composer:

```bash
$ composer create-project symfony/symfony-demo my_project
```

If you want to test the demo without installing anything locally, you can also
deploy it on Platform.sh, the official Symfony PaaS:

<p align="center">
<a href="https://console.platform.sh/projects/create-project?template=https://raw.githubusercontent.com/symfonycorp/platformsh-symfony-template-metadata/main/template-metadata-demo.yaml&utm_content=symfonycorp&utm_source=github&utm_medium=button&utm_campaign=deploy_on_platform"><img src="https://platform.sh/images/deploy/lg-blue.svg" alt="Deploy on Platform.sh" width="180px" /></a>
</p>

Usage
-----

Clone project to local:

```bash
$ git clone https://github.com/richardktran/CarForRentSymfony.git
```

Make a copy of the file `.env.example` and rename it to `.env`
Edit all the parameters in `.env` corresponding to your environment
Install all necessary packages, and dependencies by using composer:

```bash
$ composer install
```

```bash
$ cd CarForRentSymfony/
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][3] like Nginx or
Apache to run the application.


Run the project and enjoy!
