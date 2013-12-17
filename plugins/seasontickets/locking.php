<?php

  /** Request exclusive access to the season ticket
    $seasonticketid for some shows of $spectacleid. The lock is
    guaranteed valid for $lockingtime seconds (by default, four
    minutes), for the entire session. If the session already owns a
    lock for that season ticket its validity is extended.

    Technical note: Extending validity of a lock is not guaranteed to
    succeed. There's a slight risk that a lock gets "stolen" by
    another session calling this function at the exact same time, and
    having the other session get a "true" return value from this
    function and this one "false". That could be avoided by first
    attempting an update and then (in case the update had no effect)
    falling back to delete + insert.
   
    Returns true in case of success, reports an error with kaboom()
    and returns false otherwise. */
function seasontickets_lock($seasonticketid) {
  global $now, $lockingtime;
  /* 1. First drop any stale lock, or lock owned by the current session. */
  mysql_query("delete from seasontickets_lock where id=$seasonticketid and (until > $now or sid = ".quoter(session_id()).")");

  /* 2. Now try to put a new lock. This will fail if either there
   already was a lock owned by another session, or if another thread
   is in this function right now and wins the race. */
  mysql_query("insert into seasontickets_lock (id, sid, until) values ($seasonticketid, ".quoter(session_id()).
		",". ($now+$lockingtime). ")");

  /* 3. Check if lock creation succeeded. */
    if (mysql_affected_rows()==1)
      return true;
    else
      return kaboom("These season tickets are currently locked from another session. Please wait a few minutes and try again.");
}

/** Release any lock owned by the current session on the given season
 ticket. Has no effect if the current session doesn't own a lock on
 that season ticket.
 */
function seasontickets_unlock($seasonticketid) {
  mysql_query("delete from seasontickets_lock where id=$seasonticketid and sid = ".quoter(session_id()));
}

?>