<?php
/**
 * Event attendee group chats (Messages inbox threads).
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class AttendeeChats {

	/**
	 * Attendee group threads for production events.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function threads(): array {
		return array(
			array(
				'id'         => 'township-backways-route',
				'series_id'  => 'township-backways-route',
				'name'       => __( 'Township Backways · Attendees', 'xciv-social' ),
				'initial'    => 'B',
				'preview'    => __( 'Private does not mean vague. Say what you need.', 'xciv-social' ),
				'time'       => __( 'now', 'xciv-social' ),
				'unread'     => 2,
				'online'     => true,
				'active'     => true,
				'group'      => true,
				'meta'       => __( 'Attendees · Radical honesty · Meet William · MA or NC', 'xciv-social' ),
				'messages'   => array(
					array(
						'mine' => false,
						'text' => __( 'Township Backways is intimate on purpose. This chat is for highly engaged people who want the real update — not polished PR.', 'xciv-social' ),
						'time' => '8:10 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'If the vibe is not yours, leave early. Better an empty seat than a quiet room full of people pretending.', 'xciv-social' ),
						'time' => '8:12 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'Harris Houston stretch — are we keeping it tight or inviting +1s this month?', 'xciv-social' ),
						'time' => '8:18 AM',
						'from' => __( 'Member', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'Tight. Waitlist first. I will post the Saturday and Tuesday windows here the moment they are locked. Keep the conversation honest.', 'xciv-social' ),
						'time' => '8:21 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
				),
			),
		);
	}

	/**
	 * @return array<string, mixed>|null
	 */
	public static function by_id( string $id ): ?array {
		foreach ( self::threads() as $thread ) {
			if ( (string) $thread['id'] === $id ) {
				return $thread;
			}
		}
		return null;
	}
}
