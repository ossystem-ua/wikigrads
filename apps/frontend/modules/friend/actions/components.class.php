<?php
class friendComponents extends sfComponents {

    /**
    * Returns friend status icon based on $friend_status array.
    * This component requires either a $friend_status array OR $other_user_id to be provided as a variable in the include_component call.
    * If the $friend_status is not provided, it will be retrieved using the $other_user_id.
    * - $other_user_id: the user_id of the user being checked against the logged in user.
    * - $friend_status: this in an array that MUST have the following keys set:
    *   + other_user_id (required)
    *   + is_self
    *   + is_friend
    *   + is_friend_pending
    *
    * @param sfWebRequest $request
    */
    public function executeFriendStatusIcon(sfWebRequest $request) {
        if( ! isset($this->friend_status)) {
            if( ! isset($this->other_user_id)) {
                throw new Exception('friend/friendStatusIcon component requires a friendStatus array OR an $other_user_id');
            }
            $this->friend_status = $this->getUser()->getGuardUser()->getFriendStatusArray($this->other_user_id);
        }

        // friend pending icon... needs outline in some cases, and no outline in others. There are two versions of this icon. user can specify to use outline
        // when calling include_component
        $this->friend_pending_outline = (isset($this->friend_pending_outline)) ? $this->friend_pending_outline : false; // set it to false in case not passed in
        if($this->friend_pending_outline === 'false') { $this->friend_pending_outline = false; } // js could pass in 'true' or 'false' as string
    }
}
?>
