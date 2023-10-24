# Demo PODS Base project

TODO: all of the documentations

## Running on a GFE

### Happy path

Use either:

1. Docker using WSL to run Linux containers, or
2. WSL2 running Ubuntu 22.04 locally
   - To see a list of Linux distros installed on your GFE, run `wsl --list --verbose`
   - To see a list of distros that can be installed, run `wsl --list --online`
   - To install the latest Ubuntu (22.04 as of July 2023): in a bash terminal, run `wsl --install -d Ubuntu`

#### Obstacles

1. Can not access VPN from local WSL instances
   - Prevents downloading PHP, Composer to install locally
2. Can not access VPN from Docker containers
   - Prevents downloading git repositories and Docker image

### Unhappy path

Do all network activity using bash, then move the downloaded files to the container.

1. Start Docker-Desktop

1. Check if the farmos image has already been downloaded to your local Docker repo

    ```bash
    docker images
    ```

    If you see `farmos/farmos:2.x-dev` or `farmos/farmos:latest` listed then you can skip the next 2 steps

1. Manually save the Docker image using a bash terminal

    ```bash
    docker pull farmos/farmos
    ```

1. Save the image to a file using the `docker save` method

    ```bash
    docker save -o farmos.tar farmos/farmos
    ```

1. Download the necessary project repos to the host machine

7/20 I'm having trouble accessing the bitbucket repos. Getting Please make sure you have the correct access rights.

TODO: After downloading, we will start a Docker container and mount that directory as a volume in the container with something like:

```bash
docker run -v /c/Users/username/mydata:/dataincontainer -it yourimagename /bin/bash
```

Then we will need to attach the container to our farmos container.

#### Drawbacks

Slow, adds unnecessary complexity.


TODO: added podsbase.services.yml and settings.podsbase.php to a new ./config/ dir, and added their installation to composer.json. Should also add pods-
specific data here i.e. db login, etc.

## pods.sh (currently "test.sh")

Contains scripts that runs the PODS app and its dependencies.

***About this file***:

- Make this file executable: `chmod +x pods` and run it with: `./pods --command`. (Add to PATH to allow `pods --command`)
- An array `REPOS` holds the git addresses for the dependency repos. Currently is hard-coded in but should be replaced with an environment variable or something set externally.
- `check_dir()` - checks whether the current working directory is the root directory (the directory where the script lives, which should be the outer `base` directory.) If not in the root, change to the root.
- `check_vol()` - check if a given Docker volume exists. If not, attempt to create it. If creation fails, output error and exit.
- `update_repos()` - iterates over the `REPOS` array and:
  - checks if local directory already exists,
    - if yes, pull latest changes
    - if no, clone the repo
  - add the name of each created directory to the `DIRECTORIES` array for later use
- `check_os()`
- `check_connect()` - makes sure we can access the internet
- `start_docker_compose()`
- `run()`
- `pods_base` is a git repo, but when we run `./pods -u` we remove its `.git` file. This prevents us having nested repos. **If you are working directly on the `pods_base` project, comment out the line in `./pods` before running `./pods start | -s`.
- If composer complains about PHP versions when trying to require new packages, try `composer require lcobucci/clock:^2.3.0` first.
- Run composer and drush in the www container's terminal. `composer update` or `./bin/drush cr`.

### Other helpful tools
- erd
- masquerade (but would need to manually attach a role to a user since they are assigned to Consumer entities instead of users. Check this.)
