# Research: opencode snapshot cleanup git gc prune git write-tree mechanism source code

## Metadata

- **Date**: 2026-07-15 20:15
- **Original query**: opencode snapshot cleanup git gc prune git write-tree mechanism source code
- **Engines used**: brave, serper, exa
- **Total results**: 6
- **Per-engine limits**: tavily=3, brave=3, serper=2, exa=2
- **Response time**: 7122 ms
- **Deep mode**: fetched 5 pages

## Tavily

No results returned.

## Brave

### [1] Git - git-gc Documentation

- **URL**: https://git-scm.com/docs/git-gc

Git - git-gc Documentation English ▾ English Français Português (Brasil) Русский Svenska українська мова 简体中文 Topics ▾ Setup and Config git config help bugreport Credential helpers Getting and Creating Projects init clone Basic Snapshotting add status diff commit notes restore reset rm mv Branching and Merging branch checkout switch merge mergetool log stash tag worktree Sharing and Updating Projects fetch pull push remote submodule Inspection and Comparison show log diff difftool range-diff shortlog describe Patching apply cherry-pick diff rebase revert Debugging bisect blame grep Email am apply imap-send format-patch send-email request-pull External Systems svn fast-import Server Admin daemon update-server-info Guides gitattributes Command-line interface conventions Everyday Git Frequently Asked Questions (FAQ) Glossary Hooks gitignore gitmodules Revisions Submodules Tutorial Workflows All guides... Administration clean gc fsck reflog filter-branch instaweb archive bundle Plumbing Commands cat-file check-ignore checkout-index commit-tree count-objects diff-index for-each-ref hash-object ls-files ls-tree merge-base read-tree rev-list rev-parse show-ref symbolic-ref update-index update-ref verify-pack write-tree Latest version ▾ git-gc last updated in 2.52.0 2.53.0 → 2.55.0 no changes 2.52.0 2025-11-17 2.49.1 → 2.51.2 no changes 2.49.0 2025-03-14 2.47.1 → 2.48.2 no changes 2.47.0 2024-10-06 2.43.1 → 2.46.4 no changes 2.43.0 2023-11-20 2.42.1 → 2.42.4 no changes 2.42.0 2023-08-21 2.41.1 → 2.41.3 no changes 2.41.0 2023-06-01 2.38.1 → 2.40.4 no changes 2.38.0 2022-10-02 2.37.1 → 2.37.7 no changes 2.37.0 2022-06-27 2.31.1 → 2.36.6 no changes 2.31.0 2021-03-15 2.30.1 → 2.30.9 no changes 2.30.0 2020-12-27 2.24.1 → 2.29.3 no changes 2.24.0 2019-11-04 2.22.1 → 2.23.4 no changes 2.22.0 2019-06-07 2.21.1 → 2.21.4 no changes 2.21.0 2019-02-24 2.20.1 → 2.20.5 no changes 2.20.0 2018-12-09 2.19.1 → 2.19.6 no changes 2.19.0 2018-09-10 2.18.1 → 2.18.5 no changes 2.18.0 2018-06-21 2.13.7 → 2.17.6 no changes 2.12.5 2017-09-22 2.11.4 2017-09-22 2.10.5 no changes 2.9.5 2017-07-30 2.7.6 → 2.8.6 no changes 2.6.7 2017-05-05 2.5.6 no changes 2.4.12 2017-05-05 2.1.4 → 2.3.10 no changes 2.0.5 2014-12-17 NAME git-gc - Cleanup unnecessary files and optimize the local repository SYNOPSIS git gc [--aggressive] [--auto] [--[no-]detach] [--quiet] [--prune=<date> | --no-prune] [--force] [--keep-largest-pack] DESCRIPTION Runs a number of housekeeping tasks within the current repository,
such as compressing file revisions (to reduce disk space and increase
performance), removing unreachable objects which may have been
created from prior invocations of git add , packing refs, pruning
reflog, rerere metadata or stale working trees. May also update ancillary
indexes such as the commit-graph. When common porcelain operations that create objects are run, they
will check whether the repository has grown substantially since the
last maintenance, and if so run git gc automatically. See gc.auto below for how to disable this behavior. Running git gc manually should only be needed when adding objects to
a repository without regularly running such porcelain commands, to do
a one-off repository optimization, or e.g. to clean up a suboptimal
mass-import. See the "PACKFILE OPTIMIZATION" section in git-fast-import[1] for more details on the import case. OPTIONS --aggressive Usually git gc runs very quickly while providing good disk
space utilization and performance. This option will cause git gc to more aggressively optimize the repository at the expense
of taking much more time. The effects of this optimization are
mostly persistent. See the "AGGRESSIVE" section below for details. --auto With this option, git gc checks whether any housekeeping is
required; if not, it exits without performing any work. See the gc.auto option in the "CONFIGURATION" section below for how
this heuristic works. Once housekeeping is triggered by exceeding the limits of
configuration options such as gc.auto and gc.autoPackLimit , all
other housekeeping tasks (e.g. rerere, working trees, reflog…​) will
be performed as well. --detach --no-detach Run in the background if the system supports it. This option overrides
the gc.autoDetach config. --cruft --no-cruft When expiring unreachable objects, pack them separately into a
cruft pack instead of storing them as loose objects. --cruft is on by default. --max-cruft-size=<n> When packing unreachable objects into a cruft pack, limit the
size of new cruft packs to be at most <n> bytes. Overrides any
value specified via the gc.maxCruftSize configuration. See
the --max-cruft-size option of git-repack[1] for
more. --expire-to=<dir> When packing unreachable objects into a cruft pack, write a cruft
pack containing pruned objects (if any) to the directory <dir> .
This option only has an effect when used together with --cruft .
See the --expire-to option of git-repack[1] for
more information. --prune=<date> Prune loose objects older than date (de...

### [2] Git Prune: What Is Git Pruning and How to Use Git Prune | DataCamp

- **URL**: https://www.datacamp.com/tutorial/git-prune
- **Date**: August 28, 2024

Git Prune: What Is Git Pruning and How to Use Git Prune | DataCamp Skip to main content Git 's protective approach to data deletion prevents accidental loss of important commits or data. However, this can result in outdated data, such as references to deleted branches, remaining visible. Over time, Git repositories can accumulate unreferenced objects, which consume unnecessary disk space and potentially cause confusion. The git prune command is a housekeeping utility within Git, designed primarily to clean up unreachable objects in the repository. An unreachable object is an object that isn't accessible by any branch, tag, remote-tracking branch, or other reference. These objects can consume space in the repository, cluttering it with unnecessary data over time. While git prune is a powerful tool for keeping repositories lean, most users may not need to use it directly due to Git's automatic garbage collection ( git gc ). However, understanding its role and function can be helpful for advanced Git users or in specific scenarios where manual repository maintenance is required or preferred. Become a Data Engineer Become a data engineer through advanced Python learning Start Learning for Free What Is git prune ? The git prune command is used to remove objects that are no longer needed in the local repository. These objects could be commits, trees (directory snapshots), blobs (files), and tags that are no longer accessible from any branch or tag in the repository. Simply put, git prune helps clean up unnecessary files and data in the repository, saving space and reducing clutter. How can objects become unreachable? Objects can become unreachable in several ways—for instance, by deleting branches or rewriting commits. When branches are deleted, any commits unique to those branches that aren't part of any other branch or tag, become unreachable. Commit rewriting, using commands like git rebase , generates new commits and discards the old ones, leading them to become unreachable as well. Grace period and reflogs Git maintains a log of updates to branch tips and other references called reflogs (reference logs). We can view it using the git reflog command. Even if an object is unreachable, if it is still in the reflog, then it won’t be deleted by git prune . By default, the reflog has an expiration date of 90 days, providing a grace period during which unreachable objects are temporarily stored and not immediately pruned. When to Use git prune Generally, we don’t need to use git prune directly. Git has a garbage collection mechanism that runs automatically after some commands to clean up unnecessary files and optimize the local repository’s efficiency by compressing some files. Nevertheless, we may want to clean our repository manually, for example: After we perform an operation that we know will create unreachable objects, such as a branch deletion. We want to clean disk space immediately. Keeping the repository tidy and clean at all times. Garbage collection with git gc Instead of direct pruning, it is usually recommended to rely on the garbage collection mechanism, which not only performs a git prune but also optimizes space by compressing objects. As mentioned above, garbage collection will be executed automatically after some commands. We can invoke the garbage collection manually with the command: git gc How to Use git prune Because git prune will delete data, it’s recommended to execute it using the --dry-run option first. git prune --dry-run This option will list the objects that would be pruned without actually pruning them. The output would look something like: 0d7dff8258654c03a058987b3e63c86feca9200d commit
ea1380f52f0bfa0142e46767adfd56593681091a blob
fa91af78a1ab453c1d7632192b3ca8bf217ec711 commit The output indicates that there are two commits and blob that are unreachable and would be deleted. After making sure that no important data is listed, we can proceed with the cleanup: git prune In some situations, we want to clean the repository just after we perform an action that we know will lead to unreachable objects, such as a branch deletion. We may run git prune --dry-run , but the output comes out empty. The reason for this is that the deleted commits are still referenced in the reflog. If we don’t want to wait for them to expire from the reflog, we can manually expire them using the command: git reflog expire --expire-unreachable=now --all Let’s break down the options we used: The --expire-unreachable=now option sets the expiration date of all unreachable objects to now, effectively expiring them immediately. The --all option targets all the reflog entries in the repository. Without this option, we would have to specify a particular ref (like a branch or tag) on which we want to operate. git prune : Advanced Usage Let’s take a look at some advanced techniques, like specifying an expiration time or pruning packed files. Specifying an expiration time We might want only to clean older unreachable objec...

### [3] Snapshot directory can grow to 40GB+ in 7 days due to hardcoded prune=7.days · Issue #17397 · anomalyco/opencode

- **URL**: https://github.com/anomalyco/opencode/issues/17397
- **Date**: March 13, 2026

Snapshot directory can grow to 40GB+ in 7 days due to hardcoded prune=7.days · Issue #17397 · anomalyco/opencode · GitHub Skip to content Search syntax tips Provide feedback Saved searches Use saved searches to filter your results more quickly Sign in Sign up Appearance settings You signed in with another tab or window. Reload to refresh your session. You signed out in another tab or window. Reload to refresh your session. You switched accounts on another tab or window. Reload to refresh your session. Dismiss alert {{ message }} Uh oh! There was an error while loading. Please reload this page . anomalyco / opencode Public Notifications You must be signed in to change notification settings Fork 23.3k Star 186k Snapshot directory can grow to 40GB+ in 7 days due to hardcoded prune=7.days #17397 Copy link Copy link Closed Closed Snapshot directory can grow to 40GB+ in 7 days due to hardcoded prune=7.days #17397 Copy link Assignees Labels bug Something isn't working Something isn't working core Anything pertaining to core functionality of the application (opencode server stuff) Anything pertaining to core functionality of the application (opencode server stuff) perf Indicates a performance issue or need for optimization Indicates a performance issue or need for optimization Description qimenluoshu-eng opened on Mar 13, 2026 Issue body actions Description Bug: Snapshot directory fills disk during git gc --prune=7.days (disk drops 40GB in 2 hours) Description The snapshot cleanup feature ( git gc --prune=7.days ) can cause massive disk space spikes that temporarily require 2x the final pack size , potentially filling the entire disk. In my case : Available disk space dropped from 75GB to 35GB in about 2 hours, and I had to kill the git process to prevent complete disk exhaustion. Steps to Reproduce Use OpenCode for 7+ days with frequent file edits (each triggers git add . ) Allow the hourly git gc --prune=7.days task to run Observe disk space rapidly depleting as Git creates a huge pack file Root Cause Analysis Based on logs in ~/.local/share/opencode/log/ : Every file edit triggers git add . - OpenCode tracks all changes in ~/.local/share/opencode/snapshot/global/ 7 days of changes accumulate - After 7 days, thousands of loose Git objects exist When git gc runs : Reads all loose objects Writes a huge pack file (requires 2x temporary space because loose objects + new pack coexist) Only deletes loose objects after pack is complete The critical issue : If free space is less than the estimated pack size, the system can run out of disk mid-process. Evidence Before gc: 75GB available During gc: Dropped to 35GB (40GB pack file being created) Had to kill git process to prevent complete disk fill Logs show two 2.1GB pack files and one 54MB pack were created Related Issues Snapshot feature consumes 533GB+ of disk due to orphaned git temp files and unbounded growth #15977 : Snapshot uses 533GB+ disk space Snapshot system leaks tmp_pack_* files indefinitely, filling disk at ~9.5 GB/hour #14811 : tmp_pack_* files accumulate infinitely (~9.5 GB/hour) Old snapshot folders not deleted after the 7 day threshhold #10782 : Old snapshot folders not deleted after 7 days User Impact (Current Limitations) Users currently have no control over: The prune interval (hardcoded 7 days) Disk space checking before gc Maximum pack file size Manual cleanup of old snapshots Proposed Fixes Add disk space check - Abort if free space < (estimated pack size + 10GB buffer) Use --max-pack-size - Split large packs into e.g., 1GB chunks to reduce temporary space needs Make prune interval configurable - Allow users to set 1-30 days via env var (e.g., OPENCODE_SNAPSHOT_DAYS ) Add monitoring/warning - Log warnings before space runs out; optionally notify user Implement cleanup for old snapshots - Currently they're never deleted even after prune Environment OS: macOS 12.6 OpenCode version: 1.2.4 Git version: 2.39.5 Total disk: 234GB APFS Plugins No response OpenCode version OpenCode Desktop v1.2.25 Steps to reproduce No response Screenshot and/or share link No response Operating System No response Terminal No response Reactions are currently unavailable Metadata Metadata Assignees rekram1-node Labels bug Something isn't working Something isn't working core Anything pertaining to core functionality of the application (opencode server stuff) Anything pertaining to core functionality of the application (opencode server stuff) perf Indicates a performance issue or need for optimization Indicates a performance issue or need for optimization Type No type Fields No fields configured for issues without a type. Projects No projects Milestone No milestone Relationships None yet Development No branches or pull requests Issue actions You can’t perform that action at this time.

## Serper

### [1] Snapshot feature consumes 533GB+ of disk due to orphaned git temp files ...

- **URL**: https://github.com/anomalyco/opencode/issues/15977
- **Date**: Mar 4, 2026

Snapshot feature consumes 533GB+ of disk due to orphaned git temp files and unbounded growth · Issue #15977 · anomalyco/opencode · GitHub Skip to content Search syntax tips Provide feedback Saved searches Use saved searches to filter your results more quickly Sign in Sign up Appearance settings You signed in with another tab or window. Reload to refresh your session. You signed out in another tab or window. Reload to refresh your session. You switched accounts on another tab or window. Reload to refresh your session. Dismiss alert {{ message }} Uh oh! There was an error while loading. Please reload this page . anomalyco / opencode Public Notifications You must be signed in to change notification settings Fork 23.3k Star 186k Snapshot feature consumes 533GB+ of disk due to orphaned git temp files and unbounded growth #15977 Copy link Copy link Closed as not planned Closed as not planned Snapshot feature consumes 533GB+ of disk due to orphaned git temp files and unbounded growth #15977 Copy link Assignees Labels core Anything pertaining to core functionality of the application (opencode server stuff) Anything pertaining to core functionality of the application (opencode server stuff) needs:compliance This means the issue will auto-close after 2 hours. This means the issue will auto-close after 2 hours. perf Indicates a performance issue or need for optimization Indicates a performance issue or need for optimization windows Description Bewinxed opened on Mar 4, 2026 Issue body actions Note Automated bug report — This issue was filed by an AI coding agent (Claude Code) on behalf of @Bewinxed after diagnosing a disk space emergency. All data below was collected programmatically from the affected system. Summary The snapshot feature in ~/.local/share/opencode/snapshot/ consumed 533GB of disk space, filling a 1.1TB drive to 100% and causing system-wide issues. The root cause is a combination of: Abandoned git gc temporary pack files (269GB in one snapshot alone) Unbounded loose object accumulation in the global snapshot (264GB across 258 object directories) No disk usage limits, monitoring, or cleanup beyond a weekly git gc --prune=7.days Environment OpenCode version : 1.2.16 OS : WSL2 (Ubuntu), kernel 6.6.87.2-microsoft-standard-WSL2 Git : 2.43.0 Disk : 1.1TB ext4 (was at 100%, now at 49% after manual cleanup) Disk Usage Breakdown (Before Cleanup) ~/.local/share/opencode/snapshot/ 533G total
├── 0e0047b09bd609bdead33d952df5f2cf35d8207b/ 270G (project snapshot)
│ └── objects/pack/
│ ├── pack-331804b1...pack 749M (actual data, corrupted)
│ ├── tmp_pack_tK4eX9 125G ← abandoned gc temp file
│ ├── tmp_pack_mteked 72G ← abandoned gc temp file
│ └── tmp_pack_rAcec1 72G ← abandoned gc temp file
│ └── objects/79/ 813M (loose objects)
├── global/ 264G (global snapshot)
│ └── objects/pack/
│ └── tmp_pack_pjs4ru 58G ← abandoned gc temp file
│ └── objects/{56,57,64,82,94,a2,bb,cb,f0,...}/ ~1.3G each × 258 dirs
│ (~206G of loose objects)
└── (5 other snapshots) ~92M (normal size) Root Cause Analysis I traced this to the snapshot implementation in src/snapshot/index.ts . Several design issues contribute: 1. Failed git gc leaves massive temp files with no cleanup The hourly git gc --prune=7.days scheduler can fail (e.g., out of disk space, process killed, OOM) and leave tmp_pack_* files in objects/pack/ . These are never cleaned up. On my system, three abandoned temp files totaled 269GB in a single snapshot repo. Suggested fix : Before running git gc , clean up any existing tmp_pack_* files in objects/pack/ . Or add a pre-gc check like: find " ${gitdir} /objects/pack " -name ' tmp_pack_* ' -mmin +60 -delete 2. global snapshot accumulates unbounded loose objects The global snapshot had 258 object hash directories averaging 1.3GB each (~206GB of loose objects). Since write-tree creates tree objects without commits, and the index references them, git gc --prune=7.days may not actually prune them (they're technically reachable from the index). Suggested fix : Periodically reset the snapshot index, or use git prune with more aggressive settings. Consider git gc --aggressive or manual git repack -a -d with pack size limits. 3. No disk usage limits or monitoring There is no cap on snapshot storage. No check like "if snapshot dir exceeds N GB, purge old data." The only cleanup mechanism is the hourly git gc , which as shown above, can itself fail and worsen the problem. Suggested fix : Add a configurable max size (e.g., snapshot.maxSize in config). Before each Snapshot.track() , check total size and aggressively prune or disable snapshots if the limit is exceeded. 4. No .gitignore -equivalent for the global snapshot While git add . respects the project's .gitignore , the global snapshot doesn't have clear exclusion rules for large directories like ~/.cache/huggingface (92GB), ~/.cache/uv (31GB), etc. If the global snapshot's worktree covers the home directory, these all get tracked. Steps to Reproduce Use opencode on multiple projects f...

## Exa

### [1] packages/opencode/src/snapshot/index.ts

- **URL**: https://github.com/anomalyco/opencode/blob/dev/packages/opencode/src/snapshot/index.ts

opencode/packages/opencode/src/snapshot/index.ts at dev · anomalyco/opencode · GitHub Skip to content Search syntax tips Provide feedback Saved searches Use saved searches to filter your results more quickly Sign in Sign up Appearance settings You signed in with another tab or window. Reload to refresh your session. You signed out in another tab or window. Reload to refresh your session. You switched accounts on another tab or window. Reload to refresh your session. Dismiss alert {{ message }} Uh oh! There was an error while loading. Please reload this page . anomalyco / opencode Public Notifications You must be signed in to change notification settings Fork 23.3k Star 186k Expand file tree / index.ts Copy path More file actions More file actions Latest commit History History History 807 lines (730 loc) · 32.1 KB / index.ts Copy path File metadata and controls 807 lines (730 loc) · 32.1 KB Raw Copy raw file Download raw file Open symbols panel Edit and raw actions 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31 32 33 34 35 36 37 38 39 40 41 42 43 44 45 46 47 48 49 50 51 52 53 54 55 56 57 58 59 60 61 62 63 64 65 66 67 68 69 70 71 72 73 74 75 76 77 78 79 80 81 82 83 84 85 86 87 88 89 90 91 92 93 94 95 96 97 98 99 100 101 102 103 104 105 106 107 108 109 110 111 112 113 114 115 116 117 118 119 120 121 122 123 124 125 126 127 128 129 130 131 132 133 134 135 136 137 138 139 140 141 142 143 144 145 146 147 148 149 150 151 152 153 154 155 156 157 158 159 160 161 162 163 164 165 166 167 168 169 170 171 172 173 174 175 176 177 178 179 180 181 182 183 184 185 186 187 188 189 190 191 192 193 194 195 196 197 198 199 200 201 202 203 204 205 206 207 208 209 210 211 212 213 214 215 216 217 218 219 220 221 222 223 224 225 226 227 228 229 230 231 232 233 234 235 236 237 238 239 240 241 242 243 244 245 246 247 248 249 250 251 252 253 254 255 256 257 258 259 260 261 262 263 264 265 266 267 268 269 270 271 272 273 274 275 276 277 278 279 280 281 282 283 284 285 286 287 288 289 290 291 292 293 294 295 296 297 298 299 300 301 302 303 304 305 306 307 308 309 310 311 312 313 314 315 316 317 318 319 320 321 322 323 324 325 326 327 328 329 330 331 332 333 334 335 336 337 338 339 340 341 342 343 344 345 346 347 348 349 350 351 352 353 354 355 356 357 358 359 360 361 362 363 364 365 366 367 368 369 370 371 372 373 374 375 376 377 378 379 380 381 382 383 384 385 386 387 388 389 390 391 392 393 394 395 396 397 398 399 400 401 402 403 404 405 406 407 408 409 410 411 412 413 414 415 416 417 418 419 420 421 422 423 424 425 426 427 428 429 430 431 432 433 434 435 436 437 438 439 440 441 442 443 444 445 446 447 448 449 450 451 452 453 454 455 456 457 458 459 460 461 462 463 464 465 466 467 468 469 470 471 472 473 474 475 476 477 478 479 480 481 482 483 484 485 486 487 488 489 490 491 492 493 494 495 496 497 498 499 500 501 502 503 504 505 506 507 508 509 510 511 512 513 514 515 516 517 518 519 520 521 522 523 524 525 526 527 528 529 530 531 532 533 534 535 536 537 538 539 540 541 542 543 544 545 546 547 548 549 550 551 552 553 554 555 556 557 558 559 560 561 562 563 564 565 566 567 568 569 570 571 572 573 574 575 576 577 578 579 580 581 582 583 584 585 586 587 588 589 590 591 592 593 594 595 596 597 598 599 600 601 602 603 604 605 606 607 608 609 610 611 612 613 614 615 616 617 618 619 620 621 622 623 624 625 626 627 628 629 630 631 632 633 634 635 636 637 638 639 640 641 642 643 644 645 646 647 648 649 650 651 652 653 654 655 656 657 658 659 660 661 662 663 664 665 666 667 668 669 670 671 672 673 674 675 676 677 678 679 680 681 682 683 684 685 686 687 688 689 690 691 692 693 694 695 696 697 698 699 700 701 702 703 704 705 706 707 708 709 710 711 712 713 714 715 716 717 718 719 720 721 722 723 724 725 726 727 728 729 730 731 732 733 734 735 736 737 738 739 740 741 742 743 744 745 746 747 748 749 750 751 752 753 754 755 756 757 758 759 760 761 762 763 764 765 766 767 768 769 770 771 772 773 774 775 776 777 778 779 780 781 782 783 784 785 786 787 788 789 790 791 792 793 794 795 796 797 798 799 800 801 802 803 804 805 806 807 import { LayerNode } from "@opencode-ai/core/effect/layer-node" import { Cause, Duration, Effect, Layer, Schedule, Schema, Semaphore, Context } from "effect" import { ChildProcess, ChildProcessSpawner } from "effect/unstable/process" import { formatPatch, structuredPatch } from "diff" import path from "path" import { AppProcess } from "@opencode-ai/core/process" import { InstanceState } from "@/effect/instance-state" import { FSUtil } from "@opencode-ai/core/fs-util" import { Hash } from "@opencode-ai/core/util/hash" import { Config } from "@/config/config" import { Global } from "@opencode-ai/core/global" import { Info } from "@opencode-ai/schema/file-diff" export const Patch = Schema.Struct({ hash: Schema.String, files: Schema.mutable(Schema.Array(Schema.String)), }) export type Patch = typeof Patch.Type export const FileDiff = Info export type FileDiff = typeof FileDiff.Type const prun...

### [2] Review panel shows no diffs: snapshot tree objects garbage collected by git gc --prune=7.days

- **URL**: https://github.com/anomalyco/opencode/issues/18734

`snapshot/index.ts` uses `git write-tree` to capture state but never creates commit objects, leaving all tree objects **unreachable** in git's object model. The `cleanup()` function runs `git gc --prune=7.days` hourly, which prunes these unreachable trees. When `summary.ts`'s `computeDiff()` later tries to diff the first `step-start` hash against the last `step-finish` hash, the `from` hash no longer exists in the object store, `git diff-tree` fails with `fatal: bad object`, and the error is silently swallowed — producing an empty diff.
...
**Step 1: `snapshot/index.ts` — `track()` creates unreachable trees**
...
```typescript
const track = Effect.fnUntraced(function* () {
  // ...
  yield* add()  // git add .
  const result = yield* git(args(["write-tree"]), { cwd: state.directory })
  return result.text.trim()  // Returns a TREE hash — no commit is ever created
})
```
...
`git write-tree` creates a tree object from the current index. This tree is **not referenced by any commit, tag, or ref**, making it an unreachable object that is eligible for garbage collection.
...
**Step 3: `snapshot/index.ts` — `cleanup()` prunes unreachable objects**
...
```typescript
const cleanup = Effect.fnUntraced(function* () {
  yield* git(args(["gc", "--prune=7.days"]), { cwd: state.directory })
})
```
...
Runs every hour. `--prune=7.days` destroys any unreachable object older than 7 days. Since the tree objects from `write-tree` are never anchored by commits, they are always unreachable.
...
4: `summary.ts` — `computeDiff()` fails silently
...
When `diffFull(from, to)` calls `git diff-tree` with a pruned `from` hash, git returns `fatal: bad object`. The error is silently swallowed (likely via `.nothrow()`), producing an empty result.
...
### Fix 2: Disable gc or use `--prune=never`
...
```typescript
yield* git(args(["gc", "--prune=never"]), { cwd: state.directory })
...
> ## Update: Different Root Cause Identified
> 
> After deeper investigation, I've found that the issue I'm experiencing (and likely many of the "empty review panel" reports) is actually a **different and more fundamental bug** than the `git gc --prune=7.days` issue described in the original report. The gc/prune issue is likely real and separate, but what I'm actually hitting is simpler and more common.
> 
> ### The Actual Root Cause: Snapshots Disabled for Non-Git Directories
> 
> **File:** `packages/opencode/src/snapshot/index.ts` — `enabled()`:
> 
> ```typescript
> const enabled = Effect.fnUntraced(function* () {
> if (state.vcs !== "git") return false
> return (yield* config.get()).snapshot !== false
> })
> ```
> 
> When OpenCode opens a directory that has **no `.git` directory**, `fromDirectory()` in `project.ts` sets `vcs: undefined`. The snapshot system checks `state.vcs !== "git"` and **returns false** — snapshots are completely disabled. No tree hashes are ever recorded in step parts. `computeDiff()` finds no `from`/`to` hashes → empty review panel.
> 
> **Evidence from my database:** Sessions for directories opened without git have step parts with NO `"snapshot"` field:
> ```json
> {"type":"step-start"}
> {"reason":"tool-calls","type":"step-finish",...}
> ```
> 
> Compare to sessions
...
`.git` existed when the project was opened:
> ```json
> {"
...
":"4b825dc642cb6eb9a060e54bf8d69288fbee4904","type":"step-start"}
> {"reason":"tool-
...
","snapshot":"da4cd800edf4abd7c6ebdb3870325f4ca5d8460b","type":"step-finish",...}
> ```
...
Relationship to Original Report
...
> 
> The `git gc --prune=7.days` issue from the original report is likely a **separate, real bug** that affects long-running sessions where snapshots ARE working. It would cause review to break after ~7 days when the initial tree hashes get garbage collected. But many of the "empty review panel" reports (including mine) are caused by this more fundamental issue: snapshots never being created in the first place because no git repo existed when the project was first opened.

## Warnings

- tavily: Request timed out
