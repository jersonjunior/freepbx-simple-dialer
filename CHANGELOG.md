# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2025-08-08

### Major Features
- **AMD (Answering Machine Detection)**: Full implementation of voicemail detection
  - Automatically detects human vs voicemail answers
  - Optimized timing for voicemail beep detection using WaitForSilence
  - Different handling for human (immediate playback) vs voicemail (wait for beep + playback)

### Technical Changes
- **Dialplan Context**: Calls now use `simpledialer-outbound` context instead of direct Application method
  - Enables proper AMD functionality through Asterisk dialplan
  - Context automatically installed via install.php script
  - Context removed via uninstall.php script

- **Database Schema**: Enhanced call logging
  - Added `voicemail_detected` field to track AMD results
  - Added proper DEFAULT values for all required fields

- **Installation**: Automated AMD setup
  - Install script now adds dialplan context to extensions_custom.conf
  - Uninstall script properly removes context
  - No manual configuration required

### Bug Fixes
- Fixed FreePBX tamper warnings by using extensions_custom.conf instead of core files
- Fixed output buffer contamination in AJAX responses
- Fixed PJSIP channel string formatting
- Fixed daemon environment and working directory issues

### AMD Configuration
The following AMD parameters are used:
- Initial silence: 2500ms
- Greeting length: 1500ms
- After greeting silence: 800ms
- Total analysis time: 5000ms
- WaitForSilence: 1000ms (2 attempts)

### Compatibility
- Requires FreePBX with AMD module enabled
- Compatible with PJSIP and SIP trunks
- Tested with FreePBX 17+

### Upgrade Notes
For existing installations:
1. The installer will automatically add the AMD context
2. Existing campaigns will immediately benefit from AMD detection
3. No manual configuration changes required

## [1.0.0] - 2025-08-04

### Added
- **Campaign Management**: Create, edit, and delete autodialer campaigns
- **Contact Integration**: Upload CSV contacts directly during campaign creation
- **Automatic Scheduling**: Set campaigns to start automatically at specific times
- **Scheduler Daemon**: Background process that monitors and starts scheduled campaigns
- **Real-time Progress Tracking**: Live updates of campaign progress with visual indicators
- **Smart Auto-refresh**: Interface updates every 30 seconds when viewing campaigns
- **System Recording Integration**: Use FreePBX system recordings for campaign audio
- **Audio Format Conversion**: Automatic conversion to all required Asterisk formats
- **Campaign Reports**: Detailed reports with call statistics and success rates
- **Email Notifications**: Automatic email reports to system administrator
- **Report Management**: View, download, and auto-cleanup old reports
- **Visual Status Indicators**: Color-coded progress bars and status badges
- **Modal-aware Interface**: Smart refresh that pauses during form editing
- **Comprehensive Logging**: Detailed logs for troubleshooting and monitoring

### Features
- **Streamlined Workflow**: Single-step campaign creation with contact upload
- **Scheduling Validation**: Prevents conflicts between manual and automatic starts
- **Progress Visualization**: 
  - Blue animated bars for active campaigns
  - Solid green bars for completed campaigns
  - Clear contact counts and completion ratios
- **Status Management**:
  - Scheduled (blue) - Future campaigns waiting to start
  - Pending (orange) - Past scheduled time, waiting for scheduler
  - Active (with stop button) - Currently running
  - Completed (green checkmark) - Successfully finished
  - Stopped (red) - Manually terminated
- **Smart Interface**:
  - Auto-refresh only on campaigns tab
  - Pauses refresh when modals are open
  - Real-time campaign table updates
  - Confirmation messages for all actions

### Technical Details
- **Database Schema**: Three-table design for campaigns, contacts, and call logs
- **FreePBX Integration**: Full BMO compliance and proper hook integration
- **AMI Integration**: Uses Asterisk Manager Interface for call origination
- **Error Handling**: Comprehensive error handling and user feedback
- **Security**: Input validation and SQL injection prevention
- **Performance**: Efficient database queries and minimal resource usage

### Installation Requirements
- FreePBX system with administrative access
- PHP 7.4+ with CLI support
- MySQL/MariaDB database
- Asterisk with AMI configured
- Sox audio conversion tool
- Cron access for scheduling

### Configuration
- Cron job for automatic scheduling: `* * * * * php /path/to/scheduler.php`
- Audio files stored in FreePBX system recordings
- Reports stored in `/var/log/asterisk/simpledialer_reports/`
- Automatic cleanup after 7 days

### Known Issues
- None at release

### Migration Notes
- This is the initial release - no migration required
- Module creates all necessary database tables on installation
- Existing FreePBX configurations are not affected

---

## Development Notes

### Architecture Decisions
- **Single-page Application**: All functionality in one interface for better UX
- **Real-time Updates**: 30-second refresh cycle balances responsiveness with performance
- **Integrated Workflow**: Combined campaign creation and contact upload reduces steps
- **Visual Feedback**: Comprehensive status indicators improve user understanding
- **Error Prevention**: Smart validation prevents common user mistakes

### Future Enhancements (Roadmap)
- Campaign templates for reusable configurations
- Advanced reporting with charts and graphs
- Integration with CRM systems
- Support for multiple audio files per campaign
- Call result filtering and retry logic
- Campaign cloning and duplication
- REST API for external integrations
- Multi-tenant support for service providers

### Community Contributions
This module was developed collaboratively with extensive testing and refinement based on real-world usage scenarios. Special thanks to the FreePBX community for their feedback and support.