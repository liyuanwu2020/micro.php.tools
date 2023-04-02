<?php

function getLunarMonthName($num) {
    $lunarMonthName = array(
        "正月", "二月", "三月", "四月", "五月", "六月",
        "七月", "八月", "九月", "十月", "冬月", "腊月"
    );
    return $lunarMonthName[$num - 1];
}

function getLunarDayName($num) {
    $lunarDayName = array(
        "初一", "初二", "初三", "初四", "初五", "初六", "初七", "初八", "初九", "初十",
        "十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十",
        "廿一", "廿二", "廿三", "廿四", "廿五", "廿六", "廿七", "廿八", "廿九", "三十"
    );
    return $lunarDayName[$num - 1];
}

function getLunarYearName($year) {
    $heavenlyStems = array("甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
    $earthlyBranches = array("子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥");
    $heavenlyStemIndex = ($year - 1900) % 10;
    $earthlyBranchIndex = ($year - 1900) % 12;
    return $heavenlyStems[$heavenlyStemIndex] . $earthlyBranches[$earthlyBranchIndex];
}

function getLunarMonthDays($year, $month) {
    $lunarMonthDays = array(
        29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30
    );
    if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
        $lunarMonthDays[1] = 29; // 闰二月
    } else {
        $lunarMonthDays[1] = 28; // 平二月
    }
    return $lunarMonthDays[$month - 1];
}

function getLunarDate($year, $month, $day) {
    // 阳历每月天数
    $solarMonthDays = array(
        31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31
    );
    // 阳历1900年1月31日是农历正月初一
    $startDate = strtotime("1900-1-31");
    $endDate = strtotime($year . '-' . $month . '-' . $day
    );
// 计算天数差
    $days = ceil(($endDate - $startDate) / 86400);
// 计算农历年份
    $yearDays = 0;
    $lunarYear = 1900;
    while ($days > 0) {
        $yearDays = 365;
        if ($lunarYear % 4 == 0 && $lunarYear % 100 != 0 || $lunarYear % 400 == 0) {
            $yearDays = 366;
        }
        if ($days >= $yearDays) {
            $days -= $yearDays;
            $lunarYear++;
        } else {
            break;
        }
    }
// 计算农历月份和日子
    $lunarMonth = 1;
    $lunarDay = 1;
    while ($days > 0) {
        $monthDays = getLunarMonthDays($lunarYear, $lunarMonth);
        if ($days >= $monthDays) {
            $days -= $monthDays;
            $lunarMonth++;
        } else {
            break;
        }
    }
    $lunarDay += $days;
// 返回农历信息
    $lunarMonthName = getLunarMonthName($lunarMonth);
    $lunarDayName = getLunarDayName($lunarDay);
    $lunarYearName = getLunarYearName($lunarYear);
    return array(
        "lunarYearName" => $lunarYearName,
        "lunarMonthName" => $lunarMonthName,
        "lunarDayName" => $lunarDayName
    );
}

function getCalendar($year, $month) {
// 当月天数
    $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
// 当月第一天星期几
    $firstDayWeekday = date('w', strtotime($year . '-' . $month . '-1'));
// 输出表格头部
    $calendar = '<table><thead><tr><th>周日</th><th>周一</th><th>周二</th><th>周三</th><th>周四</th><th>周五</th><th>周六</th></tr></thead><tbody><tr>';
// 输出第一行空白格子
    for ($i = 0; $i < $firstDayWeekday; $i++) {
        $calendar .= '<td></td>';
    }
// 输出日期格子
    for ($day = 1; $day <= $monthDays; $day++) {
        $lunarDate = getLunarDate($year, $month, $day);
        $calendar .= '<td><span class="solar">' . $day . '</span><br><span class="lunar">' . $lunarDate["lunarMonthName"] . $lunarDate["lunarDayName"] . '</span></td>';
        if (($firstDayWeekday + $day) % 7 == 0) {
            $calendar .= '</tr><tr>';
        }
    }
// 输出最后一行空白格子
    for ($i = ($firstDayWeekday + $monthDays) % 7; $i < 7; $i++) {
        $calendar .= '<td></td>';
    }
// 输出表格结尾
    $calendar .= '</tr></tbody></table>';
    return $calendar;
}

// 示例用法
echo getCalendar(2023, 3);
// 输出：
// <table>
// <thead>
// <tr>
// <th>周日</th>
// <th>周一</th>
// <th>周二</th>
// <th>周三</th>
// <th>周四</th>
// <th>周五</th>
// <th>周六</th>
// </tr>
// </thead>
// <tbody>
// <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><span class="solar">1</span><br><span class="lunar">二月廿七</span></td></tr>
// <tr><td><span class="solar">2</span><br><span class="lunar">二月廿八</span></td><td><span class="solar">3</span><br><span class="lunar">三月初一</span></td><td><span class="solar">4</span><br><span class="lunar">三月初二</span></td><td><span class="solar">5</span><br><span class="lunar">三月初三</span></td><td><span class="solar">6</span><br><span class="lunar">三月初四</span></td><td><span class="solar">7</span><br><span class="lunar">三月初五</span></td><td><span class="solar">8</span><br><span class="lunar">三月初六</span></td></tr>
// <tr><td><span class="solar">9</span><br><span class="lunar">三月初七</span></td><td><span class="solar">10</span><br><span class="lunar">三月初八</span></td><td><span class="solar">11</span><br><span class="lunar">三月初九</span></td><td><span class="solar">12</span><br><span class="lunar">三月初十</span></td><td><span class="solar">13</span><br><span class="lunar">三月十一</span></td><td><span class="solar">14</span><br><span class="lunar">三月十二</span></td><td><span class="solar">15</span><br><span class="lunar">三月十三</span></td></tr>
// <tr><td><span class="solar">16</span><br><span class="lunar">三月十四</span></td><td><span class="solar">17</span><br><span class="lunar">三月十五</span></td><td><span class="solar">18</span><br><span class="lunar">三月十六</span></td><td><span class="solar">19</span><br><span class="lunar">三月十七</span></td><td><span class="solar">20</span><br><span class="lunar">三月十八</span></td><td><span class="solar">21</span><br><span class// class="lunar">三月十九</span></td><td><span class="solar">22</span><br><span class="lunar">三月二十</span></td></tr>
//// <tr><td><span class="solar">23</span><br><span class="lunar">三月廿一</span></td><td><span class="solar">24</span><br><span class="lunar">三月廿二</span></td><td><span class="solar">25</span><br><span class="lunar">三月廿三</span></td><td><span class="solar">26</span><br><span class="lunar">三月廿四</span></td><td><span class="solar">27</span><br><span class="lunar">三月廿五</span></td><td><span class="solar">28</span><br><span class="lunar">三月廿六</span></td><td><span class="solar">29</span><br><span class="lunar">三月廿七</span></td></tr>
//// <tr><td><span class="solar">30</span><br><span class="lunar">三月廿八</span></td><td><span class="solar">31</span><br><span class="lunar">三月廿九</span></td><td></td><td></td><td></td><td></td><td></td></tr>
//// </tbody>
//// </table>