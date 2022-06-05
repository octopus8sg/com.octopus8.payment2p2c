# com.octopus8.payment2c2p

![Screenshot](/images/screenshot.png)

(*FIXME: In one or two paragraphs, describe what the extension does and why one would download it. *)

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.2+
* CiviCRM (*FIXME: Version number*)

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.octopus8.payment2c2p@https://github.com/FIXME/com.octopus8.payment2c2p/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/com.octopus8.payment2c2p.git
cv en payment2c2p
```

## Getting Started

(* FIXME: Where would a new user navigate to get started? What changes would they see? *)

## Known Issues

- 0.1.5 - fixed error when Processor Type Name and Processor Name are different

- 0.1.6 - transaction id len = 10. 

- 0.1.7 - User name and email autofilled.

    Canceled Payment -> failed

- 0.1.8 - Thank you page absolute redirect

- 0.1.9 - Payment status ID fixed

- 0.1.10 - Failure URL

- 0.1.11 - NRIC added

- 0.1.12 - NRIC only for deductable

    