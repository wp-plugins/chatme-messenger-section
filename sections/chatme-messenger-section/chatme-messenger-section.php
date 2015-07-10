<?php
/*
Section: ChatMe Messenger Section
Author: Thomas Camaran
Author URI: http://chatme.im
Description: Add ChatMe messenger to your site. ChatMe Messenger is a XMPP client based on ConverseJS.
Class Name: DMS_ChatmeMessenger
Filter: component, social
Cloning: true
Loading: active
*/

if( ! class_exists( 'PageLinesSection' ) )
        return;

class DMS_ChatmeMessenger extends PageLinesSection {
	
	function section_scripts(){
		if( pl_get_mode() == 'live' ){
			wp_enqueue_style( 'ChatMe-Messenger', plugins_url( '/core/css/converse.min.css', __FILE__ ), array(), '0.9.4' );
			wp_enqueue_script( 'ChatMe-messenger', plugins_url( '/core/converse.min.js', __FILE__ ), array( ), '0.9.4', false);
		}	
	}	

	function section_head() {
		$defaults = array(
			'chatme_messenger_placeholder'					=> ' e.g. chatme.im',
			'chatme_messenger_language'						=> 'en',
			'chatme_messenger_webchat'						=> 'https://bind.chatme.im/',
			'chatme_messenger_providers_link'				=> 'http://chatme.im/servizi/domini-disponibili/',
			'chatme_messenger_auto_list_rooms'				=> 'false',
			'chatme_messenger_auto_subscribe'				=> 'false',
			'chatme_messenger_hide_muc_server'				=> 'false',
			'chatme_messenger_message_carbons'				=> 'true',
			'chatme_messenger_prebind'						=> 'false',
			'chatme_messenger_show_controlbox_by_default'	=> 'true',
			'chatme_messenger_xhr_user_search'				=> 'false',
		);
		
		$settings = array(
			'chatme_messenger_placeholder'						=> $this->opt('chatme_messenger_placeholder'),
			'chatme_messenger_language'							=> $this->opt('chatme_messenger_lng'),
			'chatme_messenger_webchat'							=> $this->opt('chatme_messenger_webchat'),
			'chatme_messenger_providers_link'					=> $this->opt('chatme_messenger_providers_link'),
			'chatme_messenger_auto_list_rooms'					=> $this->opt('chatme_messenger_auto_list_rooms'),
			'chatme_messenger_auto_subscribe'					=> $this->opt('chatme_messenger_auto_subscribe'),
			'chatme_messenger_hide_muc_server'					=> $this->opt('chatme_messenger_hide_muc_server'),
			'chatme_messenger_message_carbons'					=> $this->opt('chatme_messenger_message_carbons'),
			'chatme_messenger_prebind'							=> $this->opt('chatme_messenger_prebind'),
			'chatme_messenger_show_controlbox_by_default'		=> $this->opt('chatme_messenger_show_controlbox_by_default'),
			'chatme_messenger_xhr_user_search'					=> $this->opt('chatme_messenger_xhr_user_search'),
		);
		
		foreach( $settings as $k => $setting )
			if( false == $setting )
				unset( $settings[$k]);
		
		$actual = wp_parse_args( $settings, $defaults );
		
		//Show only in live mode
		if( pl_get_mode() == 'live' ){	
		printf( '
		<!-- Messenger -->
		<script defer>
			require([\'converse\'], function (converse) {
		    	converse.initialize({
		        	auto_list_rooms: %s,
		        	auto_subscribe: %s,
		        	bosh_service_url: "%s",
					domain_placeholder: "%s",
					providers_link: "%s",
		        	hide_muc_server: %s,
		        	i18n: locales.%s,
					message_carbons: %s,
		        	prebind: %s,
		        	show_controlbox_by_default: %s,
		        	xhr_user_search: %s
		    	});
			});
		</script>',
			$actual['chatme_messenger_auto_list_rooms'],
			$actual['chatme_messenger_auto_subscribe'],
			$actual['chatme_messenger_webchat'],
			$actual['chatme_messenger_placeholder'],
			$actual['chatme_messenger_providers_link'],
			$actual['chatme_messenger_hide_muc_server'],
			$actual['chatme_messenger_language'],
			$actual['chatme_messenger_message_carbons'],
			$actual['chatme_messenger_prebind'],
			$actual['chatme_messenger_show_controlbox_by_default'],
			$actual['chatme_messenger_xhr_user_search']
		);
		}
	}

	function section_template() {
	}

		function section_opts(){
			$opts = array(
				array(
					'type'		=> 'multi',
					'key'		=> 'chatme_messenger_settings',
					'title'		=> 'ChatMe Messnger',
					'help'		=> __('To add chat to all pages, just make sure you have added this section to a global area like the header or footer. This is an XMPP client based on ConverseJS.', 'tc-chatme-messenger'),
					'col'		=> 2,
					'opts'		=> array(
						array(
							'type' 			=> 'text',
							'key'			=> 'chatme_messenger_placeholder',
							'default'		=> ' e.g. chatme.im',
							'help'			=> __('The ChatMe Messenger Placeholder','tc-chatme-messenger'),
							'label'			=> __('ChatMe Messenger Placeholder, default:  e.g. chatme.im', 'tc-chatme-messenger'),
							),
						array(
							'type' 			=> 'text',
							'key'			=> 'chatme_messenger_anon_domains',
							'default'		=> 'anonymous.chatme.im',
							'help'			=> __('The anonymous server used for XMPP server','tc-chatme-messenger'),
							'label'			=> __('ChatMe anonymous domain, default anonymous.chatme.im', 'tc-chatme-messenger'),
							),
						array(
							'type' 			=> 'text',
							'key'			=> 'chatme_messenger_webchat',
							'default'		=> 'https://bind.chatme.im/',
							'help'			=> __('The url of Bind Server','tc-chatme-messenger'),
							'label'			=> __('The url of Bind server, default: https://bind.chatme.im/', 'tc-chatme-messenger'),
							),
						array(
							'type' 			=> 'text',
							'key'			=> 'chatme_messenger_providers_link',
							'default'		=> 'http://chatme.im/servizi/domini-disponibili/',
							'label'			=> __('Link of list of XMPP provider, default: http://chatme.im/servizi/domini-disponibili/', 'tc-chatme-messenger'),
							),
						array(
							'key' 		=> 'chatme_messenger_auto_list_rooms',
							'type' 		=> 'select',
							'default' 	=> 'false',
							'help'		=> __('Auto list Chat Room','tc-chatme-messenger'),
							'label' 	=> __('Auto list Chat Room, default: disabled', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),
						array(
							'key' 		=> 'chatme_messenger_auto_subscribe',
							'type' 		=> 'select',
							'default' 	=> 'false',
							'label' 	=> __('Enable Auto Subscribe.', 'tc-chatme-messenger'),
							'help'		=> __('Enable Auto Subscribe, default: false', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),
						array(
							'key' 		=> 'chatme_messenger_hide_muc_server',
							'type' 		=> 'select',
							'default' 	=> 'false',
							'help'		=> __('Hide Muc Server','tc-chatme-messenger'),
							'label' 	=> __('Hide Muc Server, default: disabled', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),
						array(
							'key' 		=> 'chatme_messenger_message_carbons',
							'type' 		=> 'select',
							'default' 	=> 'true',
							'label' 	=> __('Enable Message Carbons, default: enabled', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),
						array(
							'key' 		=> 'chatme_messenger_prebind',
							'type' 		=> 'select',
							'default' 	=> 'false',
							'label' 	=> __('Enable Prebind, default: false', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),								
						array(
							'key' 		=> 'chatme_messenger_show_controlbox_by_default',
							'type' 		=> 'select',
							'default' 	=> 'true',
							'label' 	=> __('Enable show_controlbox_by_default, default: Enabled', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),	
						array(
							'key' 		=> 'chatme_messenger_xhr_user_search',
							'type' 		=> 'select',
							'default' 	=> 'false',
							'label' 	=> __('Enable xhr_user_search, default: Disabled', 'tc-chatme-messenger'),
							'opts'=> array(
								'false' => array( 'name' => __('Disabled', 'tc-chatme-messenger') ),
								'true' 	=> array( 'name' => __('Enabled', 'tc-chatme-messenger') )
									)
							),																					
						array(
							'key' 		=> 'chatme_messenger_lng',
							'type' 		=> 'select',
							'default' 	=> 'en',
							'label' 	=> __('Select ChatMe Messenger language, default: english', 'tc-chatme-messenger'),
							'help'		=> __('Select ChatMe Messenger language', 'tc-chatme-messenger'),
							'opts'=> array(
								'ar' 	=> array( 'name' => __('ar', 'tc-chatme-messenger') ),
								'bg' 	=> array( 'name' => __('bg', 'tc-chatme-messenger') ),
                                'cs' 	=> array( 'name' => __('Česky', 'tc-chatme-messenger') ),
                                'de' 	=> array( 'name' => __('Deutsch', 'tc-chatme-messenger') ),
                                'en' 	=> array( 'name' => __('English', 'tc-chatme-messenger') ),
                                'eo' 	=> array( 'name' => __('Esperanto', 'tc-chatme-messenger') ),
                                'es' 	=> array( 'name' => __('Español', 'tc-chatme-messenger') ),
                                'et' 	=> array( 'name' => __('Eesti keel', 'tc-chatme-messenger') ),
                                'fa' 	=> array( 'name' => __('fa', 'tc-chatme-messenger') ),
                                'fr' 	=> array( 'name' => __('Français', 'tc-chatme-messenger') ),
                                'he' 	=> array( 'name' => __('he', 'tc-chatme-messenger') ),
                                'hu' 	=> array( 'name' => __('Magyar', 'tc-chatme-messenger') ),
                                'id' 	=> array( 'name' => __('Bahasa', 'tc-chatme-messenger') ),
                                'it' 	=> array( 'name' => __('Italiano', 'tc-chatme-messenger') ),
                                'ja' 	=> array( 'name' => __('ja', 'tc-chatme-messenger') ),
                                'lb' 	=> array( 'name' => __('Lëtzebuergesch', 'tc-chatme-messenger') ),
                                'mn' 	=> array( 'name' => __('Монгол', 'tc-chatme-messenger') ),
                                'nl' 	=> array( 'name' => __('Nederlands', 'tc-chatme-messenger') ),
                                'oc' 	=> array( 'name' => __('Occitan', 'tc-chatme-messenger') ),
                                'pl' 	=> array( 'name' => __('Polski', 'tc-chatme-messenger') ),
                                'pt' 	=> array( 'name' => __('Português', 'tc-chatme-messenger') ),
                                'pt-br' => array( 'name' => __('Brasileiro', 'tc-chatme-messenger') ),
                                'ru' 	=> array( 'name' => __('Русский', 'tc-chatme-messenger') ),
                                'sk' 	=> array( 'name' => __('Slovenčina', 'tc-chatme-messenger') ),
                                'sv' 	=> array( 'name' => __('Svenska', 'tc-chatme-messenger') ),
                                'tr' 	=> array( 'name' => __('Türkçe', 'tc-chatme-messenger') ),
                                'uk' 	=> array( 'name' => __('українська', 'tc-chatme-messenger') ),
                                'uz' 	=> array( 'name' => __('O\'zbek', 'tc-chatme-messenger') ),
                                'vi' 	=> array( 'name' => __('Tiếng Việt', 'tc-chatme-messenger') ),
                                'zh-cn' => array( 'name' => __('中文简体', 'tc-chatme-messenger') ),
								'zh-tw' => array( 'name' => __('中文繁體', 'tc-chatme-messenger') )
									)
							),								
						)
				)
			);
		
			return $opts;
		
		}
}
