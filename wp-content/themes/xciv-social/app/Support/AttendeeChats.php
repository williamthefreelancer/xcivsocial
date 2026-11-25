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
				'id'         => 'harrisburg-to-lynn',
				'series_id'  => 'harrisburg-to-lynn',
				'name'       => __( 'Harrisburg to Lynn · Attendees', 'xciv-social' ),
				'initial'    => 'H',
				'preview'    => __( 'Ask hard questions here. Soft talk stays outside.', 'xciv-social' ),
				'time'       => __( 'now', 'xciv-social' ),
				'unread'     => 3,
				'online'     => true,
				'active'     => true,
				'group'      => true,
				'meta'       => __( 'Attendees · Radical honesty · Charlotte → Lynn', 'xciv-social' ),
				'messages'   => array(
					array(
						'mine' => false,
						'text' => __( 'This room is for people actually coming on Harrisburg to Lynn. Radical honesty only — if you are unsure, say that out loud so we can plan real headcount.', 'xciv-social' ),
						'time' => '9:40 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'Pre-sale waitlist is open. No soft sell: when tickets drop, waitlist members get first look. Logistics lock once we hit the number.', 'xciv-social' ),
						'time' => '9:42 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'Charlotte departure — overnight or push-through? Need a straight answer from anyone already on the waitlist.', 'xciv-social' ),
						'time' => '9:48 AM',
						'from' => __( 'Member', 'xciv-social' ),
					),
					array(
						'mine' => false,
						'text' => __( 'Overnight. Exact window posts when waitlist converts. Ask the hard questions here — silence does not get you clarity.', 'xciv-social' ),
						'time' => '9:51 AM',
						'from' => __( 'Super Ninety Four', 'xciv-social' ),
					),
				),
			),
			array(
				'id'         => 'township-backways-route',
				'series_id'  => 'township-backways-route',
				'name'       => __( 'Township Backways · Attendees', 'xciv-social' ),
				'initial'    => 'B',
				'preview'    => __( 'Private does not mean vague. Say what you need.', 'xciv-social' ),
				'time'       => __( '12m', 'xciv-social' ),
				'unread'     => 2,
				'online'     => true,
				'active'     => false,
				'group'      => true,
				'meta'       => __( 'Attendees · Radical honesty · Harrisburg → Cary', 'xciv-social' ),
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
						'text' => __( 'Tight. Waitlist first. I will post the Saturday window here the moment it is locked. Keep the conversation honest.', 'xciv-social' ),
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
