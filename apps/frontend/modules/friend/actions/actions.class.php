<?php

/**
 * friend actions.
 *
 * @package    sf_sandbox_old
 * @subpackage friend
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class friendActions extends myActions {


    public function executeAjaxFriendRequestAdd(sfWebRequest $request) {

        $id = $request->getParameter('id');

        $this->forward404Unless($friend = Doctrine_Core::getTable('sfGuardUser')->find($id));

        $user = $this->getUser()->getGuardUser();

        //Add friend request, if user has not been requested
        if ( ! $user->hasFriendPendingRequest($friend)) {
            $user->addFriendRequest($friend);
            $this->sendWikimateConfirmation($user, $friend);
        }
        
        return $this->renderPartial('friend/friendRequestActions', array(
            'friend' => $friend,
        ));
    }
    
    public function executeAjaxFriendStatusIconFriendRequest(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser(); 
        $user_id = $user->getId();
        $other_user_id = $request->getParameter('id');
        $friend = Doctrine_Core::getTable('sfGuardUser')->find($other_user_id);
        #echo "<div>user_id: $user_id, friend_id: $friend_id x</div>";
        $this->forward404Unless($friend);
        
        $isSelf = ($user_id == $other_user_id);
        $isFriend = $isFriendPending = false;
        if( ! $isSelf) {
            // Add friend request, if user has not been requested
            if ( ! $user->hasFriendPendingRequest($friend)) {
                $user->addFriendRequest($friend);
                $isFriendPending = true;
                $this->sendWikimateConfirmation($user, $friend);
            } else {
                #echo "<div>says already has pending friend request</div>";
            }
        }
        
        $friend_status = array(
            'other_user_id'     => $other_user_id,
            'is_self'           => $isSelf,
            'is_friend'         => $isFriend,
            'is_friend_pending' => $isFriendPending
        );
        $friend_pending_outline = $request->getParameter('friend_pending_outline'); 
        
        sfConfig::set('sf_web_debug', false);
        return $this->renderComponent('friend', 'friendStatusIcon', array(
            'friend_status'=>$friend_status, 
            'friend_pending_outline'=>$friend_pending_outline
        ));
    }

    /*
      protected function sendFriendRequestEmail(){

      $mailer = sfContext::getInstance()->getMailer();

      $msgText = $this->getPartial('main/emailFriendRequest', array(
      'id' => $user->getId(),
      'user' => $user->getName()
      ));

      $message = $mailer->compose(sfConfig::get('app_address_noreply'),
      $friend->getEmailAddress(),
      'New Friend Request'
      );
      $message->addPart($msgText, 'text/html');

      $mailer->send($message);

      }
     */

    public function executeAjaxFriendRequestRespond(sfWebRequest $request) {
        $user_id = $request->getParameter('user_id');
        $this->forward404Unless($user = Doctrine_Core::getTable('sfGuardUser')->find($user_id));
        $this->forward404Unless($response = $request->getParameter('response'));

        $friend = $this->getUser()->getGuardUser();

        //check if logged in user (friend) has pending request from this user
        $friendRequest = $user->hasFriendRequest($friend, FriendRequest::PENDING_STATUS);

        if ($friendRequest) {
            if ($response == 'accept') {
                $friendRequest->setStatus(FriendRequest::ACCEPTED_STATUS);

                $user->addFriend($friend);

                $friend->addFriend($user);
                
                $friendship = $friend->isFriend($user);
                
                $sendNotifications = NotificationTable::insertNotifications($friendship, Notification::ADD_ACTION, Notification::EVERYONE_TYPE);
                
            } elseif ($response == 'decline') {
                $friendRequest->setStatus(FriendRequest::DECLINED_STATUS);
            }

            $friendRequest->save();
        }

        $this->redirect("@friend_request_pending_list");
    }

    public function executeAjaxFriendDelete(sfWebRequest $request) {

        $id = $request->getParameter('id');

        $this->forward404Unless($friend = Doctrine_Core::getTable('sfGuardUser')->find($id));
        $user = $this->getUser()->getGuardUser();

        //Remove mutual friendship
        $user->deleteFriend($friend);
        $friend->deleteFriend($user);

        return $this->renderPartial('friend/friendRequestActions', array(
                    'friend' => $friend,
        ));
    }

    public function executeFriendRequestPendingList(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();

        $friendRequests = $user->getFriendRequests(FriendRequest::PENDING_STATUS);

        $this->friendRequests = $friendRequests;
        
        $this->getResponse()->setTitle('WikiMate Requests');
    }

    public function executeFriendList(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        $friends = $user->getFriends();
        $this->friends = $friends;
        
        $this->getResponse()->setTitle('WikiMates');
    }
    
    protected function sendWikimateConfirmation($user, $friend){
        $message = $this->getMailer()->compose();
        
        $message->setSubject(sfConfig::get('app_mail_wikimate_confirm_subject', 'WikiMate confirmation'));
        
        $message->setFrom(array(
            'no-reply@wikigrads.com' => 'no-reply@wikigrads.com',
        ));
        
        $message->setTo(array(
            $friend->getEmailAddress() => $friend->getEmailAddress(),
        ));
        
        $message->setBody($this->getPartial('friend/friendRequestEmail', array(
            'user_first_name' => $friend->getFirstName(),
            'friend_fullname' => $user->getProfile()->getFullName(), 
            'friend_first_name' => $user->getFirstName(),
        )), 'text/html');
        
        $this->getMailer()->send($message);        
        
    }

}
