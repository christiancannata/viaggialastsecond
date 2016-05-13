# config valid only for current version of Capistrano
lock '3.4.0'

set :application, "Meritocracy-App"  # EDIT your app name
set :deploy_to, "/var/www/meritocracy-app" # EDIT folder where files should be deployed to

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, '/var/www/my_app_name'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 2


namespace :deploy do

    #desc "Build"
    #after :starting, :build do
    #        on roles(:app) do
    #           execute :sh, "/var/fix-permission.sh"
    #        end
    #end
    after :updated, :build do
        on roles(:app) do
            within release_path  do
                execute :composer, "install --no-dev --quiet" # install dependencies
                execute :chmod, "u+x artisan" # make artisan executable
                execute :php, "artisan cache:clear" # clear cache
             #   execute :php, "artisan doctrine:schema:update --force" # clear cache
            end
        end
    end



    desc "Restart"
    task :restart do
        on roles(:app) do
            within release_path  do
                execute :chmod, "-R 777 storage"
            end
        end
    end

    end


namespace :ops do

  desc 'Copy non-git ENV specific files to servers.'
  task :put_env_components do
    on roles(:app), in: :sequence, wait: 1 do
      upload! './.env.prod', "#{deploy_to}/current/.env"
      execute :chmod, "-R 775 #{deploy_to}/current/.env"
    end
  end

end
