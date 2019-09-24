# Sitegeist.Stampede 
## Svg Sprite Icons for Neos

All WIP, nothing interesting yet

**Attention: This package use the external svg references which are not supported in some older browsers. Please 
check this and polyfills like this https://github.com/Keyamoon/svgxuse if needed.**

### Authors & Sponsors

* Wilhelm Behncke - behncke@sitegeist.de
* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored by our employer https://www.sitegeist.de.*

## Configuration

The package manages icon collections that are added via settings. 

```yaml
Sitegeist:
  Stampede:
    collections:
      example: resource://Vendor.Site/Private/Icons
```

allow to select icons in a NodeType:
```yaml
'Vendor.Site:NodeType': 
  properties:
    icon:
      type: string
      ui:
        inspector:
          editor: 'Neos.Neos/Inspector/Editors/SelectBoxEditor'
          editorOptions:
            dataSourceIdentifier: 'sitegeist-stampede-icons'
            dataSourceAdditionalData:
              # Optionaly the icon collections offered to the editor
              # can be configured. By default all collections will be available   
              collections: ['example']
```

## Fusion

To render icons the prototype `Sitegeist.Stampede:Icon` is used via afx like this: 

```
    renderer = afx`
        <Sitegeist.Stampede:Icon identifier="__collectionName__:__iconName__" />
    `
```

Additionally the prototype `Sitegeist.Stampede:Icon.Preview` renders a list of all iconCollections 
as table.


## Installation

Sitegeist.Stampede is available via packagist. Just run `composer require sitegeist/stampede` to install it. We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions especially to improve the rsync, and ssh-options for a specific preset. Please send us pull requests.
