<?php
$sessionGrants = true; //false = GJP check is done every time; true = GJP check is done once per hour; significantly improves performance, slightly descreases security
$unregisteredSubmissions = false; //false = green accounts can't upload levels, appear on the leaderboards etc; true = green accounts can do everything
$preactivateAccounts = false; //false = acounts need to be activated at tools/account/activateAccount.php; true = accounts can log in immediately

/*
	Captcha settings
	Currently the only supported provider is hCaptcha
	https://www.hcaptcha.com/
*/
$enableCaptcha = true;
$hCaptchaKey = "1b19a7a5-0b21-4268-96e2-1be3a1f5f8a2";
$hCaptchaSecret = "0x763f936Cf06Bb650645276d9D350527BC6577FC3";
