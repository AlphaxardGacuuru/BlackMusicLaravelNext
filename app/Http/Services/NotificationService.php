<?php

namespace App\Http\Services;

class NotificationService
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        if (Auth::check()) {
            $getNotifications = auth('sanctum')->user()->notifications;
        } else {
            $getNotifications = [];
        }

        $notifications = [];

        foreach ($getNotifications as $notification) {

            // Check if notification is read
            $isRead = $notification->read_at ? true : false;

            array_push($notifications, [
                "id" => $notification->id,
                "type" => explode('\\', $notification->type)[2],
                "url" => $notification->data['url'],
                "from" => $notification->data['from'],
                "message" => $notification->data['message'],
                "isRead" => $isRead,
                "created_at" => $notification->created_at->format('d M Y'),
            ]);
        }

        return $notifications;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        return auth('sanctum')->user()->notifications->markAsRead();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 0) {
            auth('sanctum')->user()->notifications()->delete();
        } else {
            Notifications::find($id)->delete();
        }
    }
}