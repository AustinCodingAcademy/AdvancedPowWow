Git Basics - Day 1
==================

What is it for?
---------------

* Version control
* Collaboration

### So why not just use Dropbox?

Multiple versions/snapshots of the same file (version control) not possible with basic storage systems

Git philosophy
--------------

* DVCS = Distributed Version Control System
	- Everyone has the same copy of the repo
* SVN = Subversion (another version control system, not used so much anymore)
	- Centralized: Repos are not shared, and branching is hard	
* Commits (your snapshots) should not be the same as pushing to the server. In SVN, a commit is a push.
	- With Git, one push can push multiple commits.

### So.... what is a commit?

Analogy: Like a checkpoint or save point.

**DEFINITION: Commit**  
A commit is a name for a collection of file changes. We use that as an opportunity to create a snapshot. Commits do not store files - commits store CHANGES to files.

### What does it mean to "add" a file?

	$ git add -A ->         #  add all changes to commit
	$ git add . ->          #  add all changes except file deletions to commit
	$ git add filename.txt  #  "Add the changes to filename.txt to the next commit"

Whenever you git add a file, the changes to the file are added to the staging area. Commits capture all the changes stored in the staging area. Files themselves are not stored in the staging area, only the file "deltas" (changes).

![git add image](http://i.imgur.com/sQueWcx.png)

### What is an untracked file?

"Untracked files" are files in the working tree that have not been added to the repo at all.

### What will be the git command you use the most?

  $ git status

### git reset

  $ git reset HEAD <file> - It removes the changes to a file from staging area, but it does NOT undo the actual changes.

### How do you see all unstaged changes since the last commit?

  $ git diff
  
The main use case for git diff is to see if your change set is getting too large, and it's time to start committing.

Git Basics - Day 2
==================

Review
-------

* Commit - A named collection of changes to files
* Delta - Change
* git status
	+ what changes (if any) to files are in the working directory
	+ what changes (if any) are in the staging area
* Staging area - A temporary storage area that contains file changes designated to be committed on the next commit
* git add
	+ Takes changes to files and "moves" them to the staging area (moves?)
* git diff
	+ Without a filename specified, it displays all unstaged changes for all files since the last commit
	+ with filename, it displays unstaged changes for that specific file
* git log
	+ Summary of commits
	+ Most recent on top
	+ You can scroll through them using arrow keys

Creating patches and patching files to understand the staging area
------------------------------------------------------------------

* Copy a file in command line
	+ `$ cp origin destination`
	
* Rename a file in commandline
	+ `$ mv origin destination`
	
Creating a patch:

	$ diff -u original_file new_file > file.patch

### So what does git add actually do?

Diff files in the working tree with their corresponding files at the HEAD. Store the resulting patch in the staging area.

### Creating remote repos on github

* Can you be impersonated by someone who has your public key?
	+ No - it's *public*, it's safe to share online.
	
* git clone
	+ Downloads the remote repository to the designated directory and checks out the master branch
	+ It automatically links the local repo to the remote repo
	
* git remote
	* Mostly used with `git remote add`
	* git remote add alias git_repo_url
		+ Create a reference to a remote repository named remote_repo_alias
		+ origin is the conventional name for the default repository
		
HEAD - A special alias for the most recent commit for the repo

git push
	* Uploads and applies commits to the HEAD of the remote repository.
	* Only the commits created in the local repository since the last push are uploaded

git pull
	* Downloads and applies commits to the HEAD of the local repository
	* Only the commits created in the repository since the last pull are downloaded
	
Git Workflow
------------

* Master should always be production ready
* Branches are names for a collection of commits

![git workflow img](http://i.imgur.com/AAUpM0t.png)

### Creating a new branch

The process:

* `$ git checkout -b branch_name`
	* creates a new branch called branch_name
	* checks out the branch
	
**PULL BEFORE YOU PUSH!!!!!!!**

# See all branches available:

+ `git branch` - shows all local branches
+ `git branch -a` - shows you all local and remote branches
	
### Push to remote branch

* `$ git push -u origin branch_name`
	+ Take our current branch, push our commits to the repo at origin on the branch branch_name.
	+ -u => --set-upstream => links the remote branch to the current local branch the command
  	  was run on
	+ this means we don't have to specify `git push origin branch_name` on this branch.
	  We can just do `git push` now.
	
### Checkout branch

* `$ git checkout branch_name`
	
NOTE: `git checkout -b branch_name` => create branch called branch_name and immediately check it out

### To see the progress of  different branches

* From repo on Github, go to graphs => Network 
	
### Steps to merge branch into master

1. checkout master
2. pull latest master
3. checkout feature_branch
4. merge master in feature_branch
5. resolve conflicts if necessary
6. checkout master
7. merge feature_branch in master

### Merging

* `$ git merge`
	+ `git merge branchname` => merge branchname into currently checked out branch
	
If there's a merge conflict, use git status to see the files with conflicts
After merge conflict, git add the files you resolved
Then

`$ git commit` (no -m message)

colon wq to get out of VIM and save the commit
