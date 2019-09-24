# Sitegeist.Stampede 
## Svg Sprite Icons for Neos.

All WIP, nothing interesting yet


## Configuration

The package manages icon collections that are added via settings. 

```yaml
Sitegeist:
  Stampede:
    collections:
      example: resource://Vendor.Site/Private/Icons
```

## Fusion

To render icons the prototype `Sitegeis.Stampede:Icon` is used via afx like this: 

```
    renderer = afx`
        <Sitegeis.Stampede:Icon identifier="__collectionName__:__iconName__" />
    `
```

Additionally the prototyoe `Sitegeis.Stampede:Icon.Preview` renders a list of all iconCollections 
as table.
