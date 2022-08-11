<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class AcceptanceAssetDeclinedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->item_tag = $params['item_tag'];
        $this->item_model = $params['item_model'];
        $this->item_serial = $params['item_serial'];
        $this->accepted_date = Helper::getFormattedDateObject($params['accepted_date'], 'datetime', false);
        $this->assigned_to = $params['assigned_to'];
        $this->company_name = $params['company_name'];
        $this->settings = Setting::getSettings();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notifyBy[] = 'mail';

        return $notifyBy;

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }

        $message = (new MailMessage)->markdown('notifications.markdown.asset-requested',
            [
                'item_tag'      => $this->item_tag,
                'item_model'    => $this->item_model,
                'item_serial'   => $this->item_serial,
                'accepted_date' => $this->accepted_date,
                'assigned_to'   => $this->assigned_to,
                'company_name'  => $this->company_name,
                'intro_text'    => trans('mail.acceptance_asset_declined'),
            ])
            ->subject(trans('mail.acceptance_asset_declined'));

        return $message;
    }

}
