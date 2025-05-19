<?php

namespace App\Models;

use Illuminate\Support\HtmlString;
use App\Models\Comment;
use App\Models\User;

class CommentPresenter
{
    /**
     * @var Comment
     */
    public Comment $comment;

    /**
     * @param  Comment  $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return HtmlString
     */
    public function markdownBody(): HtmlString
    {
        return new HtmlString(app('markdown')->convertToHtml($this->comment->body));
    }

    /**
     * @return mixed
     */
    public function relativeCreatedAt(): mixed
    {
        return $this->comment->created_at->diffForHumans();
    }

    /**
     * @param $text
     * @return array|string
     */
    public function replaceUserMentions($text): array|string
    {
        preg_match_all('/@([A-Za-z0-9_]+)/', $text, $matches);
        $usernames = $matches[1];
        $replacements = [];

        foreach ($usernames as $username) {
            $user = User::where('username', $username)->first();

            if ($user) {

                $replacements['@'.$username] = '<a href="'.route('profile',$user->username).'" class="text-primary-500 font-medium hover:underline">@'.$username.
                    '</a>';
            } else {
                $replacements['@'.$username] = '@'.$username;
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }


}
