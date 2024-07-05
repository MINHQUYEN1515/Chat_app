import 'dart:convert';
import 'dart:io';

import 'package:client/service/local_notification.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/widgets.dart';

class FireBaseService {
  late String _tokenFireBase;
  late FirebaseMessaging _firebaseMessaging;
  FireBaseService._privateContructor() {
    _firebaseMessaging = FirebaseMessaging.instance;
  }
  static final FireBaseService instance = FireBaseService._privateContructor();
  String get tokenFireBase => _tokenFireBase;
  Future<void> init({VoidCallback? callback}) async {
    await _requestPermissionNotification();
    await _getToken();
    await LocalNotification.init();
    _handleNotification(callback: callback);
  }

  Future<void> _requestPermissionNotification() async {
    NotificationSettings notificationSettings =
        await _firebaseMessaging.requestPermission(
            alert: true, badge: true, provisional: false, sound: true);
    await _firebaseMessaging.setForegroundNotificationPresentationOptions(
        alert: true, badge: true, sound: true);
    switch (notificationSettings.authorizationStatus) {
      case AuthorizationStatus.authorized:
        print("LOG>>:granted permission");
        break;
      case AuthorizationStatus.denied:
        print("LOG>>:granted provisional permission");
        break;
      default:
        print("LOG>>:not accept permission");
        break;
    }
  }

  Future<void> _getToken() async {
    String? token = await _firebaseMessaging.getToken();
    if (token != null) {
      _tokenFireBase = token;
      print("LOG>>:Token firebase: $_tokenFireBase");
    } else {
      print("LOG>>:Get token failed");
    }
  }

  Future<void> _handleNotification({VoidCallback? callback}) async {
    if (Platform.isAndroid) {
      FirebaseMessaging.onMessage.listen((RemoteMessage message) {
        if (message.notification != null) {
          _showMessage(message);
          callback?.call();
        }
      });
    }
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      print("LOG>>:$message.data");
    });
  }

  void _showMessage(RemoteMessage message) {
    LocalNotification.showNotification(
      id: 0,
      title: message.notification?.title ?? '',
      body: message.notification?.body ?? '',
      payload: json.encode(message.data),
    );
  }
}
