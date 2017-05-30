# Add your own tasks in files placed in lib/tasks ending in .rake,
# for example lib/tasks/capistrano.rake, and they will automatically be available to Rake.

require File.expand_path('../config/application', __FILE__)

Rails.application.load_tasks

task('spec').clear

RSpec::Core::RakeTask.new(:spec) do |t, _task_args|
  t.rspec_opts = '--format RspecJunitFormatter --out target/test-results.xml'
end

desc 'Verifies solution'
task :verify do
  Rake::Task['db:create'].invoke
  Rake::Task['db:test:prepare'].invoke
  Rake::Task['spec'].invoke
end
