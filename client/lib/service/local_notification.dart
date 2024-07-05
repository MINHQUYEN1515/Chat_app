import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class LocalNotification {
  static final _localNotificationService = FlutterLocalNotificationsPlugin();
  static Future<void> init() async {
    AndroidInitializationSettings androidInitializationSettings =
        const AndroidInitializationSettings('@mipmap/ic_launcher');
    DarwinInitializationSettings darwinInitializationSettings =
        const DarwinInitializationSettings(
            requestAlertPermission: false,
            requestBadgePermission: false,
            requestSoundPermission: false,
            onDidReceiveLocalNotification: onDidReceiveLocalNotification);
    final InitializationSettings initializationSettings =
        InitializationSettings(
            android: androidInitializationSettings,
            iOS: darwinInitializationSettings);
    await _localNotificationService.initialize(initializationSettings,
        onDidReceiveNotificationResponse: (NotificationResponse notification) {
      switch (notification.notificationResponseType) {
        case NotificationResponseType.selectedNotification:
          print("LOG>>:------------------ selectedNotification");
          break;
        case NotificationResponseType.selectedNotificationAction:
          print("LOG>>:------------------Click  action notification");
          break;
      }
    });
  }

  static Future<NotificationDetails> _notificationDetail() async {
    const AndroidNotificationDetails androidNotificationDetails =
        AndroidNotificationDetails('channel_notification', 'channel_name',
            channelDescription: 'description',
            importance: Importance.max,
            priority: Priority.max,
            playSound: true);
    const DarwinNotificationDetails iosNotificationDetail =
        DarwinNotificationDetails();
    return const NotificationDetails(
        android: androidNotificationDetails, iOS: iosNotificationDetail);
  }

  static Future<void> showNotification(
      {required int id,
      required String title,
      required String body,
      required String payload}) async {
    final detail = await _notificationDetail();
    await _localNotificationService.show(id, title, body, detail,
        payload: payload);
  }

  static void onDidReceiveLocalNotification(
      int? id, String? title, String? body, String? payload) async {
    print(
        '------------------- onDidReceiveLocalNotification -------------- $title');
  }
}
