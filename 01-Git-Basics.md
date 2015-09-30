Git Basics
==========

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

### What is an untracked file?

"Untracked files" are files in the working tree that have not been added to the repo at all.

### What will be the git command you use the most?

  $ git status

### git reset

  $ git reset HEAD <file> - It removes the changes to a file from staging area, but it does NOT undo the actual changes.

### How do you see all unstaged changes since the last commit?

  $ git diff
  
The main use case for git diff is to see if your change set is getting too large, and it's time to start committing.
